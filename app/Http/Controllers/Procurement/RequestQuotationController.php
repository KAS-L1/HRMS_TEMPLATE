<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement\RequestQuotation;
use Illuminate\Http\Request;

class RequestQuotationController extends Controller
{
    // Get all quotations
    public function index()
    {
        return RequestQuotation::with(['product', 'vendor'])->get();
    }

    // Get a specific quotation by ID
    public function show($id)
    {
        $quotation = RequestQuotation::with(['product', 'vendor'])->findOrFail($id);

        return response()->json($quotation);
    }

    // Create a new quotation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'vendor_id' => 'required|exists:users,user_id',
            'requested_qty' => 'required|integer',
            'status' => 'required|in:Pending,Responded,Rejected',
            'response_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $quotation = RequestQuotation::create($validated);

        return response()->json($quotation, 201);
    }

    // Update an existing quotation
    public function update(Request $request, $id)
    {
        $quotation = RequestQuotation::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,product_id',
            'vendor_id' => 'nullable|exists:users,user_id',
            'requested_qty' => 'nullable|integer',
            'status' => 'nullable|in:Pending,Responded,Rejected',
            'response_date' => 'nullable|date',
            'remarks' => 'nullable|string',
        ]);

        $quotation->update($validated);

        return response()->json($quotation);
    }

    // Delete a quotation
    public function destroy($id)
    {
        $quotation = RequestQuotation::findOrFail($id);
        $quotation->delete();

        return response()->json(['message' => 'Quotation deleted successfully']);
    }
}
