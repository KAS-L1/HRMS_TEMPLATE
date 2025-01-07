<?php

namespace Database\Factories\Procurement;

use App\Models\Procurement\RequestQuotation;
use App\Models\Procurement\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RequestQuotationFactory extends Factory
{
    protected $model = RequestQuotation::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Generate a UUID for the primary key
            'rfq_id' => $this->generateUniqueRfqId(), // Generate a unique RFQ ID
            'product_id' => Product::factory(), // Use factory to create Product
            'vendor_id' => User::factory(), // Use factory to create Vendor
            'requested_qty' => $this->faker->numberBetween(1, 100),
            'status' => $this->faker->randomElement(['Pending', 'Responded', 'Rejected']),
            'response_date' => $this->faker->optional()->dateTime, // Optional response date
            'remarks' => $this->faker->optional()->sentence, // Optional remarks
        ];
    }

    private function generateUniqueRfqId(): int
    {
        do {
            $rfqId = (int) ('66' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (RequestQuotation::where('rfq_id', $rfqId)->exists()); // Check for uniqueness in the database

        return $rfqId;
    }
}
