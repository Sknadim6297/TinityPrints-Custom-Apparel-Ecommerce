<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DesignRequest;
use Illuminate\Http\Request;

class DesignApprovalController extends Controller
{
    public function index()
    {
        $designRequests = DesignRequest::orderBy('created_at', 'desc')->paginate(12);

        return view('admin.design-approvals.index', compact('designRequests'));
    }

    public function approve(Request $request, DesignRequest $designRequest)
    {
        $designRequest->update([
            'status' => 'approved',
            'remarks' => $request->input('remarks'),
            'payment_unlocked' => true,
            'reviewed_by' => auth()->guard('admin')->id(),
            'reviewed_at' => now(),
        ]);

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
}
