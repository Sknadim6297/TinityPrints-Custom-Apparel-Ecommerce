<?php

namespace App\Services\Shipping;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class ShiprocketService
{
    public function isMockMode(): bool
    {
        return config('shipping.shiprocket.mode', 'mock') !== 'live';
    }

    public function calculateShippingCost(?int $weightGrams): float
    {
        $threshold = (int) config('shipping.weight_threshold_grams', 100);
        $ratePerGram = (int) config('shipping.cost_per_extra_gram', 20);

        if ($weightGrams === null || $weightGrams <= $threshold) {
            return 0.00;
        }

        return (float) (($weightGrams - $threshold) * $ratePerGram);
    }

    public function calculateOrderWeight(Order $order): int
    {
        $order->loadMissing(['items.product']);

        $itemWeight = (int) $order->items->sum(function ($item) {
            $unitWeight = (int) ($item->product?->product_weight_grams ?? config('shipping.default_product_weight_grams', 250));

            return max(1, $unitWeight) * max(1, (int) $item->quantity);
        });

        if ($itemWeight > 0) {
            return $itemWeight;
        }

        $existingWeight = (int) ($order->shipping_weight_grams ?? 0);

        if ($existingWeight > 0) {
            return $existingWeight;
        }

        return max(1, (int) config('shipping.default_product_weight_grams', 250));
    }

    public function createShipment(Order $order, array $overrides = []): array
    {
        if (!$this->isMockMode()) {
            return $this->createLiveShipment($order, $overrides);
        }

        return $this->createMockShipment($order, $overrides);
    }

    public function syncShipment(Order $order, array $overrides = []): array
    {
        if (!$this->isMockMode()) {
            return $this->syncLiveShipment($order, $overrides);
        }

        return $this->syncMockShipment($order, $overrides);
    }

    private function createMockShipment(Order $order, array $overrides = []): array
    {
        $weightGrams = (int) ($overrides['shipping_weight_grams'] ?? $this->calculateOrderWeight($order));
        $shippingCost = $this->calculateShippingCost($weightGrams);
        $trackingNumber = $overrides['tracking_number'] ?? $order->tracking_number ?? $this->generateTrackingNumber($order);
        $shippingMethod = $overrides['shipping_method'] ?? $order->shipping_method ?? $this->defaultShippingMethod();
        $shippingPartner = $overrides['shipping_partner'] ?? config('shipping.default_partner', 'Shiprocket');

        $order->update([
            'shipping_partner' => $shippingPartner,
            'shipping_weight_grams' => $weightGrams,
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
            'tracking_number' => $trackingNumber,
            'delivery_status' => 'shipped',
            'order_status' => 'shipped',
            'shipped_at' => $order->shipped_at ?? now(),
        ]);

        return [
            'mode' => $this->isMockMode() ? 'mock' : 'live',
            'status' => 'created',
            'shipment_id' => $this->generateShipmentId($order),
            'tracking_number' => $trackingNumber,
            'shipping_partner' => $shippingPartner,
            'shipping_method' => $shippingMethod,
            'shipping_weight_grams' => $weightGrams,
            'shipping_cost' => $shippingCost,
            'delivery_status' => 'shipped',
        ];
    }

    private function syncMockShipment(Order $order, array $overrides = []): array
    {
        $currentStatus = $overrides['delivery_status'] ?? $this->inferDeliveryStatus($order);
        $trackingNumber = $order->tracking_number ?? $this->generateTrackingNumber($order);
        $shippingCost = $this->calculateShippingCost((int) ($order->shipping_weight_grams ?? 0));
        $shippingPartner = $order->shipping_partner ?? config('shipping.default_partner', 'Shiprocket');
        $shippingMethod = $order->shipping_method ?? $this->defaultShippingMethod();

        $updateData = [
            'shipping_partner' => $shippingPartner,
            'tracking_number' => $trackingNumber,
            'shipping_method' => $shippingMethod,
            'shipping_cost' => $shippingCost,
            'delivery_status' => $currentStatus,
        ];

        if (in_array($currentStatus, ['shipped', 'delivered'], true)) {
            $updateData['order_status'] = $currentStatus;

            if ($currentStatus === 'shipped' && !$order->shipped_at) {
                $updateData['shipped_at'] = now();
            }

            if ($currentStatus === 'delivered') {
                $updateData['delivered_at'] = $order->delivered_at ?? now();
                $updateData['delivered_date'] = $order->delivered_date ?? now();
            }
        }

        $order->update($updateData);

        return [
            'mode' => $this->isMockMode() ? 'mock' : 'live',
            'status' => 'synced',
            'shipment_id' => $this->generateShipmentId($order),
            'tracking_number' => $trackingNumber,
            'shipping_partner' => $shippingPartner,
            'shipping_method' => $shippingMethod,
            'shipping_weight_grams' => $order->shipping_weight_grams,
            'shipping_cost' => $shippingCost,
            'delivery_status' => $currentStatus,
        ];
    }

    private function createLiveShipment(Order $order, array $overrides = []): array
    {
        // Always recalculate weight - don't rely on order.shipping_weight_grams which might be 0
        $weightGrams = (int) ($overrides['shipping_weight_grams'] ?? $this->calculateOrderWeight($order));
        
        // Ensure weight is never 0 or negative
        if ($weightGrams <= 0) {
            $weightGrams = (int) config('shipping.default_product_weight_grams', 250);
        }
        
        $shippingCost = $this->calculateShippingCost($weightGrams);
        $shippingMethod = $overrides['shipping_method'] ?? $order->shipping_method ?? $this->defaultShippingMethod();
        $shippingPartner = $overrides['shipping_partner'] ?? config('shipping.default_partner', 'Shiprocket');

        Log::info('Preparing Shiprocket shipment', [
            'order_id' => $order->id,
            'weight_grams' => $weightGrams,
            'weight_kg' => $weightGrams / 1000,
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
        ]);

        $createResponse = $this->requestShiprocket('POST', '/orders/create/adhoc', $this->buildOrderPayload($order, [
            'shipping_method' => $shippingMethod,
            'shipping_weight_grams' => $weightGrams,
        ]));

        Log::info('Shiprocket order creation response', [
            'order_id' => $order->id,
            'response' => $createResponse,
        ]);

        // Extract shipment_id for AWB generation (NOT order_id)
        $shipmentId = $createResponse['shipment_id'] 
            ?? data_get($createResponse, 'data.shipment_id')
            ?? data_get($createResponse, 'response.shipment_id');
        
        $awbResponse = null;

        Log::info('Extracted shipment ID from create response', [
            'order_id' => $order->id,
            'shipment_id' => $shipmentId,
        ]);

        if ($shipmentId) {
            try {
                $awbResponse = $this->generateAwb($shipmentId);
                Log::info('Shiprocket AWB generation successful', [
                    'order_id' => $order->id,
                    'shipment_id' => $shipmentId,
                    'response' => $awbResponse,
                ]);
            } catch (\Throwable $exception) {
                Log::warning('Shiprocket AWB generation failed.', [
                    'order_id' => $order->id,
                    'shipment_id' => $shipmentId,
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                ]);
            }
        }

        // Extract AWB code from responses - do NOT use fake order_id fallback
        $trackingNumber = $this->extractAwbCode($awbResponse)
            ?? $this->extractAwbCode($createResponse);

        Log::info('Tracking number extraction result', [
            'order_id' => $order->id,
            'shipment_id' => $shipmentId,
            'tracking_number' => $trackingNumber,
            'awb_response' => $awbResponse,
        ]);

        if (!$trackingNumber) {
            Log::warning('AWB not generated.', [
                'order_id' => $order->id,
                'shipment_id' => $shipmentId,
                'create_response' => $createResponse,
                'awb_response' => $awbResponse,
            ]);

            $order->update([
                'shipping_partner' => $shippingPartner,
                'shipping_weight_grams' => $weightGrams,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $shippingMethod,
                'delivery_status' => 'pending',
            ]);

            return [
                'mode' => 'live',
                'status' => 'awb_pending',
                'shipment_id' => $shipmentId ?: $this->generateShipmentId($order),
                'tracking_number' => null,
                'shipping_partner' => $shippingPartner,
                'shipping_method' => $shippingMethod,
                'shipping_weight_grams' => $weightGrams,
                'shipping_cost' => $shippingCost,
                'delivery_status' => 'pending',
                'message' => 'Shipment created but AWB pending. Please recharge wallet.',
            ];
        }

        $order->update([
            'shipping_partner' => $shippingPartner,
            'shipping_weight_grams' => $weightGrams,
            'shipping_cost' => $shippingCost,
            'shipping_method' => $shippingMethod,
            'tracking_number' => $trackingNumber,
            'delivery_status' => 'shipped',
            'order_status' => 'shipped',
            'shipped_at' => $order->shipped_at ?? now(),
        ]);

        return [
            'mode' => 'live',
            'status' => 'created',
            'shipment_id' => $shipmentId ?: $this->generateShipmentId($order),
            'tracking_number' => $trackingNumber,
            'shipping_partner' => $shippingPartner,
            'shipping_method' => $shippingMethod,
            'shipping_weight_grams' => $weightGrams,
            'shipping_cost' => $shippingCost,
            'delivery_status' => 'shipped',
        ];
    }

    private function syncLiveShipment(Order $order, array $overrides = []): array
    {
        $currentStatus = $overrides['delivery_status'] ?? $this->inferDeliveryStatus($order);
        $trackingNumber = $order->tracking_number ?? $this->generateTrackingNumber($order);
        $shippingWeightGrams = $this->calculateOrderWeight($order);
        $shippingCost = $this->calculateShippingCost($shippingWeightGrams);
        $shippingPartner = $order->shipping_partner ?? config('shipping.default_partner', 'Shiprocket');
        $shippingMethod = $order->shipping_method ?? $this->defaultShippingMethod();

        $updateData = [
            'shipping_partner' => $shippingPartner,
            'tracking_number' => $trackingNumber,
            'shipping_method' => $shippingMethod,
            'shipping_cost' => $shippingCost,
            'shipping_weight_grams' => $shippingWeightGrams,
            'delivery_status' => $currentStatus,
        ];

        if (in_array($currentStatus, ['shipped', 'delivered'], true)) {
            $updateData['order_status'] = $currentStatus;

            if ($currentStatus === 'shipped' && !$order->shipped_at) {
                $updateData['shipped_at'] = now();
            }

            if ($currentStatus === 'delivered') {
                $updateData['delivered_at'] = $order->delivered_at ?? now();
                $updateData['delivered_date'] = $order->delivered_date ?? now();
            }
        }

        $order->update($updateData);

        return [
            'mode' => 'live',
            'status' => 'synced',
            'shipment_id' => $this->generateShipmentId($order),
            'tracking_number' => $trackingNumber,
            'shipping_partner' => $shippingPartner,
            'shipping_method' => $shippingMethod,
            'shipping_weight_grams' => $shippingWeightGrams,
            'shipping_cost' => $shippingCost,
            'delivery_status' => $currentStatus,
        ];
    }

    public function defaultShippingMethod(): string
    {
        return config('shipping.shiprocket.default_shipping_method', 'Shiprocket Standard');
    }

    public function generateTrackingNumber(Order $order): string
    {
        $prefix = config('shipping.shiprocket.tracking_prefix', 'SR-MOCK');

        return sprintf(
            '%s-%s-%s',
            $prefix,
            str_pad((string) $order->id, 5, '0', STR_PAD_LEFT),
            strtoupper(Str::random(6))
        );
    }

    private function shiprocketClient()
    {
        return rtrim((string) config('shipping.shiprocket.base_url', 'https://apiv2.shiprocket.in/v1/external'), '/');
    }

    private function getAuthToken(): string
    {
        $configuredToken = trim((string) config('shipping.shiprocket.token', ''));

        if ($configuredToken !== '') {
            return $configuredToken;
        }

        return Cache::remember('shiprocket.auth_token', now()->addMinutes(45), function () {
            $email = trim((string) config('shipping.shiprocket.email', ''));
            $password = (string) config('shipping.shiprocket.password', '');

            if ($email === '' || $password === '') {
                throw new RuntimeException('Shiprocket email and password are required for live mode.');
            }

            $response = $this->requestShiprocket('POST', '/auth/login', [
                'email' => $email,
                'password' => $password,
            ], false);

            $token = data_get($response, 'token')
                ?? data_get($response, 'data.token')
                ?? data_get($response, 'access_token');

            if (!$token) {
                throw new RuntimeException('Shiprocket authentication did not return a token.');
            }

            return (string) $token;
        });
    }

    private function buildOrderPayload(Order $order, array $overrides = []): array
    {
        $order->loadMissing(['items.product']);

        $shippingAddress = trim((string) $order->shipping_address);
        $shippingName = trim((string) $order->customer_name);
        $shippingPhone = $this->normalizePhone((string) $order->phone);
        $shippingEmail = trim((string) $order->email);
        $shippingCountry = $this->normalizeCountry((string) $order->shipping_country);
        $shippingCity = $this->normalizeCity((string) $order->shipping_city, $shippingAddress, (string) $order->shipping_state);
        $shippingPostalCode = $this->normalizePostalCode((string) ($order->shipping_postal_code ?? ''), (string) $order->shipping_city, $shippingAddress);
        
        // Get weight in grams - ensure it's never 0 or negative
        $weightGrams = (int) ($overrides['shipping_weight_grams'] ?? $order->shipping_weight_grams ?? 0);
        if ($weightGrams <= 0) {
            $weightGrams = (int) config('shipping.default_product_weight_grams', 250);
        }
        $weightKg = max(0.1, $weightGrams / 1000);

        $items = $order->items->isNotEmpty()
            ? $order->items->map(function ($item) {
                return [
                    'name' => $item->product_name,
                    'sku' => (string) ($item->product_id ?? $item->id),
                    'units' => (int) $item->quantity,
                    'selling_price' => (float) $item->price,
                    'discount' => 0,
                    'tax' => 0,
                    'hsn' => '',
                ];
            })->values()->all()
            : [[
                'name' => $order->product_name,
                'sku' => (string) ($order->product_id ?? $order->id),
                'units' => (int) $order->quantity,
                'selling_price' => (float) $order->total_amount,
                'discount' => (float) ($order->discount_amount ?? 0),
                'tax' => 0,
                'hsn' => '',
            ]];

        $payload = [
            'order_id' => $this->buildShiprocketOrderId($order),
            'order_date' => optional($order->created_at ?? now())->format('Y-m-d H:i'),
            'pickup_location' => config('shipping.shiprocket.pickup_location', 'Primary'),
            'comment' => 'Created from application admin shipment flow',
            'billing_customer_name' => $shippingName,
            'billing_last_name' => '',
            'billing_address' => $shippingAddress,
            'billing_address_2' => '',
            'billing_city' => $shippingCity,
            'billing_pincode' => $shippingPostalCode,
            'billing_state' => trim((string) $order->shipping_state),
            'billing_country' => $shippingCountry,
            'billing_email' => $shippingEmail,
            'billing_phone' => $shippingPhone,
            'shipping_is_billing' => true,
            'shipping_customer_name' => $shippingName,
            'shipping_last_name' => '',
            'shipping_address' => $shippingAddress,
            'shipping_address_2' => '',
            'shipping_city' => $shippingCity,
            'shipping_pincode' => $shippingPostalCode,
            'shipping_country' => $shippingCountry,
            'shipping_state' => trim((string) $order->shipping_state),
            'shipping_email' => $shippingEmail,
            'shipping_phone' => $shippingPhone,
            'order_items' => $items,
            'payment_method' => $this->normalizePaymentMethod((string) ($order->payment_method ?? 'cod')),
            'shipping_charges' => (float) ($order->shipping_cost ?? 0),
            'giftwrap_charges' => 0,
            'transaction_charges' => 0,
            'total_discount' => (float) ($order->discount_amount ?? 0),
            'sub_total' => (float) ($order->subtotal ?? $order->total_amount ?? 0),
            'length' => (float) ($overrides['length'] ?? 10),
            'breadth' => (float) ($overrides['breadth'] ?? 10),
            'height' => (float) ($overrides['height'] ?? 2),
            'weight' => $weightKg,
        ];

        Log::debug('Shiprocket payload weight', [
            'order_id' => $order->id,
            'weight_grams' => $weightGrams,
            'weight_kg' => $weightKg,
            'order_shipping_weight_grams' => $order->shipping_weight_grams,
            'override_weight_grams' => $overrides['shipping_weight_grams'] ?? null,
        ]);

        $channelId = trim((string) config('shipping.shiprocket.channel_id', ''));

        if ($channelId !== '') {
            $payload['channel_id'] = $channelId;
        }

        return $payload;
    }

    private function extractShiprocketReference(array $payload, array $keys = ['order_id', 'shipment_id']): ?string
    {
        foreach ($keys as $key) {
            $value = data_get($payload, $key) ?? data_get($payload, 'data.' . $key) ?? data_get($payload, 'response.' . $key);

            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }

    private function extractAwbCode(?array $payload): ?string
    {
        if (!$payload) {
            return null;
        }

        // Check top-level keys
        foreach (['awb_code', 'awb', 'awb_no', 'tracking_number'] as $key) {
            $value = data_get($payload, $key);
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        // Check nested data.* keys
        foreach (['awb_code', 'awb', 'awb_no', 'tracking_number'] as $key) {
            $value = data_get($payload, 'data.' . $key);
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        // Check nested response.* keys
        foreach (['awb_code', 'awb', 'awb_no', 'tracking_number'] as $key) {
            $value = data_get($payload, 'response.' . $key);
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        // Check nested courier_assign_status or shipment_data
        foreach (['courier_assign_status', 'shipment_data'] as $key) {
            $value = data_get($payload, $key);
            if (is_array($value)) {
                foreach (['awb_code', 'awb', 'awb_no', 'tracking_number'] as $subkey) {
                    $subvalue = data_get($value, $subkey);
                    if (is_string($subvalue) && trim($subvalue) !== '') {
                        return trim($subvalue);
                    }
                }
            }
        }

        return null;
    }

    private function generateAwb(string $shipmentReference): array
    {
        $attempts = [
            ['/courier/generate/awb', ['shipment_id' => $shipmentReference]],
            ['/courier/assign/awb', ['shipment_id' => $shipmentReference]],
        ];

        $lastException = null;

        foreach ($attempts as [$endpoint, $body]) {
            try {
                return $this->requestShiprocket('POST', $endpoint, $body);
            } catch (\Throwable $exception) {
                $lastException = $exception;
            }
        }

        if ($lastException) {
            throw $lastException;
        }

        throw new RuntimeException('Unable to generate AWB from Shiprocket.');
    }

    private function requestShiprocket(string $method, string $path, ?array $payload = null, bool $includeAuthToken = true): array
    {
        $baseUrl = $this->shiprocketClient();
        $url = $baseUrl . '/' . ltrim($path, '/');
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        if ($includeAuthToken) {
            $headers[] = 'Authorization: Bearer ' . $this->getAuthToken();
        }

        $curl = curl_init($url);

        if ($curl === false) {
            throw new RuntimeException('Unable to initialize Shiprocket request.');
        }

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 15,
        ];

        if ($payload !== null) {
            $options[CURLOPT_POSTFIELDS] = json_encode($payload, JSON_UNESCAPED_SLASHES);
        }

        curl_setopt_array($curl, $options);
        $responseBody = curl_exec($curl);
        $curlError = curl_error($curl);
        $curlErrorCode = curl_errno($curl);
        $statusCode = (int) curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        if ($responseBody === false || $curlErrorCode !== 0) {
            Log::error('Shiprocket request failed.', [
                'url' => $url,
                'error' => $curlError,
                'code' => $curlErrorCode,
            ]);

            throw new RuntimeException('Unable to connect to Shiprocket.');
        }

        $decoded = json_decode($responseBody, true);

        if (!is_array($decoded)) {
            Log::error('Shiprocket returned invalid JSON.', [
                'url' => $url,
                'status' => $statusCode,
                'body' => $responseBody,
            ]);

            throw new RuntimeException('Shiprocket returned an invalid response.');
        }

        if ($statusCode >= 400) {
            Log::error('Shiprocket request returned an error status.', [
                'url' => $url,
                'status' => $statusCode,
                'response' => $decoded,
            ]);

            $message = data_get($decoded, 'message')
                ?? data_get($decoded, 'error')
                ?? 'Shiprocket request failed.';

            throw new RuntimeException((string) $message);
        }

        return $decoded;
    }

    private function normalizePaymentMethod(string $paymentMethod): string
    {
        return in_array(strtolower(trim($paymentMethod)), ['cod', 'cash_on_delivery'], true)
            ? 'COD'
            : 'Prepaid';
    }

    private function normalizeCountry(string $country): string
    {
        $normalized = strtoupper(trim($country));

        return match ($normalized) {
            'IN', 'IND', 'INDIA' => 'India',
            'PK', 'PAK', 'PAKISTAN' => 'Pakistan',
            default => trim($country) ?: 'India',
        };
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }

        return $digits;
    }

    private function normalizeCity(string $city, string $shippingAddress, string $shippingState): string
    {
        $city = trim($city);

        if ($city !== '' && !ctype_digit($city)) {
            return $city;
        }

        $candidate = trim((string) strtok($shippingAddress, ','));

        if ($candidate !== '' && !ctype_digit($candidate)) {
            return $candidate;
        }

        $stateCandidate = trim($shippingState);

        if ($stateCandidate !== '' && !ctype_digit($stateCandidate)) {
            return $stateCandidate;
        }

        return $city !== '' ? $city : 'Unknown';
    }

    private function normalizePostalCode(string $postalCode, string $city, string $shippingAddress): string
    {
        $postalCode = trim($postalCode);

        if ($postalCode !== '' && preg_match('/^\d{4,10}$/', $postalCode)) {
            return $postalCode;
        }

        if (preg_match('/^\d{4,10}$/', trim($city))) {
            return trim($city);
        }

        if (preg_match('/\b(\d{4,10})\b/', $shippingAddress, $matches)) {
            return $matches[1];
        }

        return $postalCode;
    }

    private function inferDeliveryStatus(Order $order): string
    {
        if ($order->order_status === 'delivered' || $order->delivery_status === 'delivered') {
            return 'delivered';
        }

        if ($order->order_status === 'shipped' || $order->tracking_number) {
            return 'shipped';
        }

        return 'pending';
    }

    private function generateShipmentId(Order $order): string
    {
        return 'SR-SHIP-' . now()->format('Ymd') . '-' . str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);
    }

    private function buildShiprocketOrderId(Order $order): string
    {
        $baseOrderId = trim((string) $order->order_number);

        if ($baseOrderId === '') {
            $baseOrderId = 'ORD-' . str_pad((string) $order->id, 8, '0', STR_PAD_LEFT);
        }

        if (!$order->tracking_number && !$order->shipped_at && !$order->shipping_partner) {
            return $baseOrderId;
        }

        return $baseOrderId . '-R' . now()->format('His');
    }
}