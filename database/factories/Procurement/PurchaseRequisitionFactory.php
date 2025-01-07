<?php

namespace Database\Factories\Procurement;

use App\Models\Procurement\PurchaseRequisition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseRequisitionFactory extends Factory
{
    protected $model = PurchaseRequisition::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Generate a UUID for the primary key
            'requisition_id' => $this->generateUniqueRequisitionId(),
            'vendor_id' => User::factory(), // Use factory to create Vendor
            'created_by' => User::factory(), // Use factory to create Creator
            'total_quantity' => $this->faker->randomFloat(2, 10, 500),
            'total_cost' => $this->faker->randomFloat(2, 500, 10000),
            'total_price' => $this->faker->randomFloat(2, 600, 12000),
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'request_date' => $this->faker->dateTime,
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
        ];
    }

    private function generateUniqueRequisitionId(): int
    {
        do {
            $requisitionId = (int) ('33' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (PurchaseRequisition::where('requisition_id', $requisitionId)->exists()); // Check for uniqueness in the database

        return $requisitionId;
    }
}
