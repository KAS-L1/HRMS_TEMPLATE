<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Procurement\Product;
use App\Models\User;
use App\Models\Procurement\PurchaseRequisition;
use App\Models\Procurement\PurchaseItem;
use App\Models\Procurement\BudgetApproval;
use App\Models\Procurement\RequestQuotation;

class ProcurementSeeder extends Seeder
{
    public function run(): void
    {
        // Create Vendors
        $vendors = User::factory(10)->create();

        // Create Products
        $products = Product::factory(20)->create();

        // Create Purchase Requisitions
        $requisitions = PurchaseRequisition::factory(10)->create()->each(function ($requisition) use ($vendors, $products) {
            // Assign a random vendor to the requisition
            $requisition->update([
                'vendor_id' => $vendors->random()->id, // Assign valid vendor UUID
            ]);

            // Create Purchase Items for the requisition
            foreach (range(1, 5) as $_) { // Create 5 items per requisition
                PurchaseItem::factory()->create([
                    'requisition_id' => $requisition->id, // Assign valid requisition UUID
                    'product_id' => $products->random()->id, // Assign valid product UUID
                ]);
            }

            // Create Budget Approval for the requisition
            BudgetApproval::factory()->create([
                'requisition_id' => $requisition->id, // Assign valid requisition UUID
            ]);
        });

        // Create Request Quotations for Products
        foreach ($products as $product) {
            foreach (range(1, 5) as $_) { // Create 5 quotations per product
                RequestQuotation::factory()->create([
                    'product_id' => $product->id, // Assign valid product UUID
                    'vendor_id' => $vendors->random()->id, // Assign valid vendor UUID
                ]);
            }
        }
    }
}
