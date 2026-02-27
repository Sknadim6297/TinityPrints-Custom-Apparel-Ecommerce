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
        $designRequests = DesignRequest::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.design-approvals.index', compact('designRequests'));
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
