<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    protected $api;

    /**
     * Get or initialize Razorpay API
     */
    protected function getApi()
    {
        if ($this->api) {
            return $this->api;
        }

        try {
            $keyId = env('RAZORPAY_KEY_ID') ?? config('payments.razorpay.key_id');
            $keySecret = env('RAZORPAY_KEY_SECRET') ?? config('payments.razorpay.key_secret');

            if (!$keyId || !$keySecret) {
                throw new \Exception('Razorpay keys not configured in .env or config/payments.php');
            }

            // Use full namespace with use statement at top
            return $this->api = new Api($keyId, $keySecret);
        } catch (\Exception $e) {
            Log::error('Razorpay initialization error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Create Razorpay order for payment
     */
    public function createRazorpayOrder($orderId)
    {
        try {
            $api = $this->getApi();

            $order = Order::with('user')->findOrFail($orderId);

            // Check if order belongs to authenticated user
            if ($order->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Unauthorized access to this order'
                ], 403);
            }

            // Check if payment already exists and is completed
            $existingPayment = Payment::where('order_id', $orderId)
                ->where('status', 'completed')
                ->first();

            if ($existingPayment) {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment already completed for this order'
                ], 400);
            }

            // Validate order total amount
            if (!$order->total_amount || $order->total_amount <= 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid order amount'
                ], 400);
            }

            // Create Razorpay order
            $amount = (int)($order->total_amount * 100); // Convert to paise
            
            $razorpayOrder = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => 'order_' . $order->id . '_' . time(),
                'notes' => [
                    'order_id' => (string)$order->id,
                    'user_id' => (string)auth()->id(),
                    'order_number' => $order->order_number,
                ],
            ]);

            // Create or update payment record
            $payment = Payment::updateOrCreate(
                ['order_id' => $orderId],
                [
                    'user_id' => auth()->id(),
                    'razorpay_order_id' => $razorpayOrder->id,
                    'amount' => $order->total_amount,
                    'currency' => 'INR',
                    'status' => 'initiated',
                ]
            );

            $keyId = env('RAZORPAY_KEY_ID') ?? config('payments.razorpay.key_id');

            Log::info('Razorpay order created', [
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $order->total_amount,
            ]);

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $amount,
                'currency' => 'INR',
                'key' => $keyId,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->email,
                'customer_phone' => $order->phone,
            ]);

        } catch (\Throwable $e) {
            Log::error('Razorpay createRazorpayOrder error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'order_id' => $orderId ?? 'unknown',
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to create payment order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle Razorpay payment callback
     */
    public function handleCallback(Request $request)
    {
        try {
            Log::info('Payment callback received', [
                'payment_id' => $request->input('razorpay_payment_id'),
                'order_id' => $request->input('razorpay_order_id'),
            ]);

            $paymentId = $request->input('razorpay_payment_id');
            $orderId = $request->input('razorpay_order_id');
            $signature = $request->input('razorpay_signature');

            if (!$paymentId || !$orderId || !$signature) {
                Log::error('Missing payment parameters', [
                    'payment_id' => $paymentId,
                    'order_id' => $orderId,
                    'signature' => $signature,
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Missing required payment parameters'
                ], 400);
            }

            // Get API instance with better error handling
            try {
                $api = $this->getApi();
            } catch (\Exception $e) {
                Log::error('Failed to initialize Razorpay API in callback', [
                    'error' => $e->getMessage(),
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'API initialization failed'
                ], 500);
            }

            // Verify signature
            try {
                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id' => $orderId,
                    'razorpay_payment_id' => $paymentId,
                    'razorpay_signature' => $signature,
                ]);
                Log::info('Signature verification successful', ['payment_id' => $paymentId]);
            } catch (SignatureVerificationError $e) {
                Log::error('Razorpay signature verification failed', [
                    'error' => $e->getMessage(),
                    'payment_id' => $paymentId,
                    'order_id' => $orderId,
                ]);

                return response()->json([
                    'success' => false,
                    'error' => 'Payment signature verification failed'
                ], 400);
            }

            // Find payment record by razorpay_order_id
            $payment = Payment::where('razorpay_order_id', $orderId)->first();

            if (!$payment) {
                Log::error('Payment record not found', ['razorpay_order_id' => $orderId]);
                return response()->json([
                    'success' => false,
                    'error' => 'Payment record not found'
                ], 404);
            }

            Log::info('Payment record found', [
                'payment_id_db' => $payment->id,
                'razorpay_order_id' => $orderId,
            ]);

            // Get payment details from Razorpay - with error handling
            try {
                $razorpayPayment = $api->payment->fetch($paymentId);
                Log::info('Razorpay payment fetched successfully', [
                    'payment_id' => $paymentId,
                    'method' => $razorpayPayment->method ?? 'unknown',
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to fetch Razorpay payment details', [
                    'payment_id' => $paymentId,
                    'error' => $e->getMessage(),
                ]);
                // Continue with update even if fetch fails, as signature is already verified
                $razorpayPayment = null;
            }

            // Update payment record
            $updateData = [
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'status' => 'completed',
                'payment_completed_at' => now(),
            ];

            if ($razorpayPayment) {
                $updateData['payment_method'] = $razorpayPayment->method ?? null;
                // Only try to json_encode if it's an object
                try {
                    $updateData['response_data'] = json_encode((array)$razorpayPayment);
                } catch (\Exception $e) {
                    Log::warning('Failed to JSON encode payment data', ['error' => $e->getMessage()]);
                }
            }

            $payment->update($updateData);
            Log::info('Payment record updated', ['payment_id' => $payment->id]);

            // Update order status
            try {
                $order = $payment->order;
                if (!$order) {
                    Log::error('Order not found for payment', ['payment_id' => $payment->id]);
                    return response()->json([
                        'success' => false,
                        'error' => 'Associated order not found'
                    ], 404);
                }

                $order->update([
                    'payment_status' => 'paid',
                    'order_status' => 'paid',
                    'paid_at' => now(),
                ]);
                Log::info('Order updated', ['order_id' => $order->id]);
            } catch (\Exception $e) {
                Log::error('Failed to update order', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to update order status'
                ], 500);
            }

            Log::info('Payment verified successfully', [
                'order_id' => $order->id,
                'payment_id' => $paymentId,
                'amount' => $order->total_amount,
            ]);

            // Notify admin about successful payment
            try {
                AdminNotifier::notifyAll(
                    'Payment Received',
                    'Payment of ₹' . number_format($order->total_amount, 2) . ' received for Order ' . $order->order_number,
                    'success',
                    route('admin.orders.index'),
                    'View Order',
                    ['order_id' => $order->id]
                );
            } catch (\Exception $notifyError) {
                Log::warning('Failed to notify admin of payment', ['error' => $notifyError->getMessage()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'order_id' => $order->id,
            ]);

        } catch (SignatureVerificationError $e) {
            Log::error('Payment signature verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Payment verification failed'
            ], 400);
        } catch (\Throwable $e) {
            Log::error('Payment callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle failed payment
     */
    public function handleFailure(Request $request)
    {
        try {
            $razorpayOrderId = $request->input('razorpay_order_id');
            $errorCode = $request->input('error_code');
            $errorDescription = $request->input('error_description');

            if ($razorpayOrderId) {
                $payment = Payment::where('razorpay_order_id', $razorpayOrderId)->first();

                if ($payment) {
                    $errorMessage = ($errorCode ? $errorCode . ': ' : '') . ($errorDescription ?? 'Unknown error');
                    $payment->markAsFailed($errorMessage);

                    $order = $payment->order;
                    $order->update([
                        'payment_status' => 'failed',
                        'order_status' => 'payment_pending',
                    ]);

                    Log::warning('Payment failed', [
                        'order_id' => $order->id,
                        'error' => $errorMessage,
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Payment failed',
                'error' => $errorDescription ?? 'Payment processing failed',
            ], 400);

        } catch (\Throwable $e) {
            Log::error('Payment failure handler error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to process payment failure'
            ], 500);
        }
    }

    /**
     * Payment success page
     */
    public function success($orderId)
    {
        $order = Order::with(['items.product.images', 'payment'])
            ->where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if payment is completed
        if ($order->payment && $order->payment->status === 'completed') {
            return view('frontend.payment-success', compact('order'));
        }

        return redirect()->route('order.details', $orderId)
            ->with('error', 'Payment not completed. Please try again.');
    }

    /**
     * Payment failure page
     */
    public function failure($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.payment-failure', compact('order'));
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($orderId)
    {
        $order = Order::with('payment')
            ->where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$order->payment) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'No payment record found',
            ]);
        }

        return response()->json([
            'status' => $order->payment->status,
            'payment_method' => $order->payment->payment_method,
            'amount' => $order->payment->amount,
            'completed_at' => $order->payment->payment_completed_at,
        ]);
    }

    /**
     * Test Razorpay configuration (Debug endpoint)
     */
    public function testConfig()
    {
        $keyId = env('RAZORPAY_KEY_ID') ?? config('payments.razorpay.key_id');
        $keySecret = env('RAZORPAY_KEY_SECRET') ?? config('payments.razorpay.key_secret');

        $razorpayClassExists = class_exists('Razorpay\Api\Api');
        
        $response = [
            'status' => 'ok',
            'env_razorpay_key_id' => env('RAZORPAY_KEY_ID') ? 'SET' : 'NOT SET',
            'env_razorpay_key_secret' => env('RAZORPAY_KEY_SECRET') ? 'SET' : 'NOT SET',
            'config_loaded' => config('payments.razorpay.key_id') ? true : false,
            'key_id_exists' => $keyId ? true : false,
            'key_secret_exists' => $keySecret ? true : false,
            'razorpay_class_found' => $razorpayClassExists,
            'key_id_preview' => $keyId ? substr($keyId, 0, 10) . '...' : 'NOT SET',
            'autoloader_file' => file_exists(base_path('vendor/autoload.php')) ? 'EXISTS' : 'MISSING',
        ];

        if ($razorpayClassExists) {
            try {
                // Try to instantiate API
                $testKeyId = 'rzp_test_dummy';
                $testKeySecret = 'test_secret';
                $api = new \Razorpay\Api\Api($testKeyId, $testKeySecret);
                $response['razorpay_api_instantiation'] = 'SUCCESS';
            } catch (\Exception $e) {
                $response['razorpay_api_instantiation'] = 'FAILED: ' . $e->getMessage();
            }
        } else {
            $response['razorpay_api_instantiation'] = 'FAILED: Class not found';
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            $response['full_key_id'] = $keyId ?? 'NOT SET';
            $response['full_config'] = [
                'RAZORPAY_KEY_ID' => env('RAZORPAY_KEY_ID'),
                'RAZORPAY_KEY_SECRET' => env('RAZORPAY_KEY_SECRET'),
            ];
            $response['php_version'] = phpversion();
            $response['laravel_version'] = app()->version();
        }

        return response()->json($response);
    }
}
