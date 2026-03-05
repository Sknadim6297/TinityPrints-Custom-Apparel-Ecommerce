<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignRequest;
use App\Support\AdminNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignApprovalController extends Controller
{
    public function index()
    {
        $search = request('search');

        $designRequests = DesignRequest::query();

        if ($search) {
            $designRequests->where(function ($query) use ($search) {
                $query->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('selected_size', 'like', "%{$search}%");
            });
        }

        $designRequests = $designRequests->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('admin.design-approvals.index', compact('designRequests', 'search'));
    }

    public function show(DesignRequest $designRequest)
    {
        return view('admin.design-approvals.show', compact('designRequest'));
    }

    public function approve(Request $request, DesignRequest $designRequest)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:1|max:999999.99',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $designRequest->update([
            'status' => 'approved',
            'price' => $validated['price'],
            'remarks' => $request->input('remarks'),
            'admin_remark' => $request->input('remarks'),
            'payment_unlocked' => true,
            'file_locked' => true,
            'reviewed_by' => auth()->guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

        AdminNotifier::notifyAll(
            'Design approved',
            'Design request #' . $designRequest->id . ' has been approved.',
            'success',
            route('admin.design-approvals.index'),
            'View designs',
            ['design_request_id' => $designRequest->id, 'status' => 'approved']
        );

        return redirect()->route('admin.design-approvals.index')
            ->with('success', 'Design approved. Payment unlocked.');
    }

    public function reject(Request $request, DesignRequest $designRequest)
    {
        $request->validate([
            'remarks' => 'required|string|min:3',
        ]);

        $designRequest->update([
            'status' => 'rejected',
            'remarks' => $request->input('remarks'),
            'payment_unlocked' => false,
            'reviewed_by' => auth()->guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

        AdminNotifier::notifyAll(
            'Design rejected',
            'Design request #' . $designRequest->id . ' has been rejected.',
            'warning',
            route('admin.design-approvals.index'),
            'View designs',
            ['design_request_id' => $designRequest->id, 'status' => 'rejected']
        );

        return redirect()->route('admin.design-approvals.index')
            ->with('success', 'Design rejected.');
    }

    public function requestChanges(Request $request, DesignRequest $designRequest)
    {
        $request->validate([
            'remarks' => 'required|string|min:3',
        ]);

        $designRequest->update([
            'status' => 'changes_requested',
            'remarks' => $request->input('remarks'),
            'payment_unlocked' => false,
            'reviewed_by' => auth()->guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.design-approvals.index')
            ->with('success', 'Changes requested for this design.');
    }

    public function updateChecks(Request $request, DesignRequest $designRequest)
    {
        $validated = $request->validate([
            'file_format' => 'nullable|in:png,psd,ai',
            'dpi' => 'nullable|integer|min:72|max:1200',
            'print_width' => 'nullable|numeric|min:0.1',
            'print_height' => 'nullable|numeric|min:0.1',
            'print_unit' => 'nullable|in:in,cm,mm',
        ]);

        $designRequest->update($validated);

        return redirect()->route('admin.design-approvals.index')
            ->with('success', 'File checks updated successfully.');
    }

    public function updateFile(Request $request, DesignRequest $designRequest)
    {
        $validated = $request->validate([
            'design_file' => 'required|file|mimes:png,psd,ai|max:10240',
        ]);

        $file = $validated['design_file'];
        $path = $file->store('designs', 'public');
        $checksum = hash_file('sha256', $file->getRealPath());
        $extension = strtolower($file->getClientOriginalExtension());

        $designRequest->update([
            'design_file_path' => $path,
            'file_format' => $extension,
            'file_checksum' => $checksum,
            'file_updated_at' => now(),
            'file_locked' => false,
            'status' => 'pending',
            'payment_unlocked' => false,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return redirect()->route('admin.design-approvals.index')
            ->with('success', 'Design file updated. Re-approval required.');
    }

    public function download(DesignRequest $designRequest, string $fileType)
    {
        $path = $fileType === 'front'
            ? ($designRequest->front_design_file ?: $designRequest->design_file_path)
            : $designRequest->back_design_file;

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if (!$path || !$disk->exists($path)) {
            return redirect()->route('admin.design-approvals.index')
                ->with('error', ucfirst($fileType).' design file not found.');
        }

        if (method_exists($disk, 'download')) {
            return $disk->download($path);
        }

        return response()->download($disk->path($path));
    }

    public function toggleLock(Request $request, DesignRequest $designRequest)
    {
        $locked = (bool) $request->input('locked');

        $designRequest->update([
            'file_locked' => $locked,
        ]);

        return redirect()->route('admin.design-approvals.index')
            ->with('success', $locked ? 'File locked.' : 'File unlocked.');
    }
}
