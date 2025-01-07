<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement\BudgetApproval;
use Illuminate\Http\Request;

class BudgetApprovalController extends Controller
{
    // Get all budget approvals
    public function index()
    {
        return BudgetApproval::with('requisition')->get();
    }

    // Get a single budget approval by ID
    public function show($id)
    {
        $approval = BudgetApproval::with('requisition')->findOrFail($id);

        return response()->json($approval);
    }

    // Create a new budget approval
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requisition_id' => 'required|exists:purchase_requisitions,requisition_id',
            'amount' => 'required|numeric',
            'status' => 'required|in:Pending,Approved,Rejected',
            'approved_by' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $approval = BudgetApproval::create($validated);

        return response()->json($approval, 201);
    }

    // Update an existing budget approval
    public function update(Request $request, $id)
    {
        $approval = BudgetApproval::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'nullable|numeric',
            'status' => 'nullable|in:Pending,Approved,Rejected',
            'approved_by' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $approval->update($validated);

        return response()->json($approval);
    }

    // Delete a budget approval
    public function destroy($id)
    {
        $approval = BudgetApproval::findOrFail($id);
        $approval->delete();

        return response()->json(['message' => 'Budget approval deleted successfully']);
    }
}
