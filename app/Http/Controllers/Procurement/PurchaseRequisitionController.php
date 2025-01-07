<?php

namespace App\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Procurement\PurchaseRequisition;

class PurchaseRequisitionController extends Controller
{
    public function index()
    {
        $requisitions = PurchaseRequisition::with(['vendor', 'creator'])->paginate(10);

        // Pass the data to the Blade view
        // return view('procurement.requisitions.index', compact('requisitions'));

        return response()->json($requisitions);
    }

    public function show($id)
    {
        $requisition = PurchaseRequisition::with(['vendor', 'creator', 'purchaseItems.product'])->findOrFail($id);

        return response()->json([
            'requisition_id' => $requisition->requisition_id,
            'vendor' => $requisition->vendor ? [
                'id' => $requisition->vendor->user_id,
                'company' => $requisition->vendor->company,
                'name' => $requisition->vendor->full_name,
            ] : null,
            'creator' => $requisition->creator ? [
                'id' => $requisition->creator->user_id,
                'name' => $requisition->creator->full_name,
            ] : null,
            'total_quantity' => $requisition->total_quantity,
            'total_cost' => $requisition->total_cost,
            'total_price' => $requisition->total_price,
            'priority' => $requisition->priority,
            'request_date' => $requisition->request_date,
            'status' => $requisition->status,
            'purchase_items' => $requisition->purchaseItems,
        ]);

        // return view('procurement.requisitions.show', compact(var_name: 'requisition'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:users,user_id',
            'total_quantity' => 'required|numeric|min:1',
            'total_cost' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'priority' => 'required|in:Low,Medium,High',
            'request_date' => 'required|date',
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $requisition = PurchaseRequisition::create(array_merge($validated, [
            'created_by' => auth()->id(),
        ]));

        return response()->json($requisition, 201);
    }

    public function update(Request $request, $id)
    {
        $requisition = PurchaseRequisition::findOrFail($id);

        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:users,user_id',
            'total_quantity' => 'nullable|numeric|min:1',
            'total_cost' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'priority' => 'nullable|in:Low,Medium,High',
            'request_date' => 'nullable|date',
            'status' => 'nullable|in:Pending,Approved,Rejected',
        ]);

        $requisition->update($validated);

        return response()->json($requisition);
    }

    public function destroy($id)
    {
        $requisition = PurchaseRequisition::findOrFail($id);
        $requisition->delete();

        return response()->json(['message' => 'Requisition deleted successfully']);
    }

    public function create()
    {
        return view('requisitions.create'); // Assuming your Blade file is in the 'requisitions' directory
    }


    public function edit($id)
    {
        $requisition = PurchaseRequisition::findOrFail($id);

        return view('procurement.requisitions.edit', compact('requisition'));
    }
}
