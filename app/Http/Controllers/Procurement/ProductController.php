<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'required|in:Available,Unavailable',
            'unit_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        return Product::create($validated);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'nullable|in:Available,Unavailable',
            'unit_price' => 'nullable|numeric',
            'stock' => 'nullable|integer',
        ]);

        $product->update($validated);

        return $product;
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
