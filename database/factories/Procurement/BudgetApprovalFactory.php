<?php

namespace Database\Factories\Procurement;

use App\Models\Procurement\BudgetApproval;
use App\Models\Procurement\PurchaseRequisition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BudgetApprovalFactory extends Factory
{
    protected $model = BudgetApproval::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Generate a UUID for the primary key
            'approval_id' => $this->generateUniqueApprovalId(), // Generate a unique approval ID
            'requisition_id' => PurchaseRequisition::factory(), // Generate a related PurchaseRequisition with UUID
            'amount' => $this->faker->randomFloat(2, 1000, 20000),
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'approved_by' => $this->faker->name,
            'approval_date' => $this->faker->optional()->dateTime, // Optional approval date
            'remarks' => $this->faker->optional()->sentence, // Optional remarks
        ];
    }

    private function generateUniqueApprovalId(): int
    {
        do {
            $approvalId = (int) ('55' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (BudgetApproval::where('approval_id', $approvalId)->exists()); // Check for uniqueness in the database

        return $approvalId;
    }
}
