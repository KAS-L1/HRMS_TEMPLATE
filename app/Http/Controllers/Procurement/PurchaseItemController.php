<?php

namespace App\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Procurement\PurchaseItem;

class PurchaseItemController extends Controller
{
    // Get all purchase items
    public function index()
    {
        return PurchaseItem::with(['requisition', 'product'])->get();
    }

    // Get a single purchase item by ID
    public function show($id)
    {
        $item = PurchaseItem::with(['requisition', 'product'])->findOrFail($id);

        return response()->json($item);
    }

    // Create a new purchase item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'requisition_id' => 'required|exists:purchase_requisitions,requisition_id',
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $item = PurchaseItem::create($validated);

        return response()->json($item, 201);
    }

    // Update an existing purchase item
    public function update(Request $request, $id)
    {
        $item = PurchaseItem::findOrFail($id);

        $validated = $request->validate([
            'requisition_id' => 'nullable|exists:purchase_requisitions,requisition_id',
            'product_id' => 'nullable|exists:products,product_id',
            'quantity' => 'nullable|integer',
            'cost' => 'nullable|numeric',
            'price' => 'nullable|numeric',
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    // Delete a purchase item
    public function destroy($id)
    {
        $item = PurchaseItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Purchase item deleted successfully']);
    }

    public function purchasedOrders()
    {
        $purchaseItemCount = PurchaseItem::count();  // Count all PurchaseItem records
        return view('dashboard.analytics', compact('purchaseItemCount'));
    }
}
