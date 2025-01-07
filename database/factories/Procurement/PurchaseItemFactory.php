<?php

namespace Database\Factories\Procurement;

use App\Models\Procurement\PurchaseItem;
use App\Models\Procurement\Product;
use App\Models\Procurement\PurchaseRequisition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseItemFactory extends Factory
{
    protected $model = PurchaseItem::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Generate a UUID for the primary key
            'purchase_id' => $this->generateUniquePurchaseId(), // Generate a unique purchase ID            ''
            'requisition_id' => PurchaseRequisition::factory(), // Use factory to create Purchase Requisition
            'product_id' => Product::factory(), // Use factory to create Product
            'quantity' => $this->faker->numberBetween(1, 50),
            'cost' => $this->faker->randomFloat(2, 50, 1000),
            'price' => $this->faker->randomFloat(2, 100, 2000),
        ];
    }

    private function generateUniquePurchaseId(): int
    {
        do {
            $purchaseId = (int) ('44' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (PurchaseItem::where('purchase_id', $purchaseId)->exists()); // Check for uniqueness in the database

        return $purchaseId;
    }
}
