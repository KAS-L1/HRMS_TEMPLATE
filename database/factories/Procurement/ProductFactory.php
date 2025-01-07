<?php

namespace Database\Factories\Procurement;

use App\Models\Procurement\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'id' => (string) Str::uuid(), // Generate a UUID for the primary key
            'product_id' => $this->generateUniqueProductId(), // Generate a unique product ID
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'image' => $this->faker->imageUrl(640, 480, 'products', true, 'Faker'), // Generate a product-related image
            'status' => $this->faker->randomElement(['Available', 'Unavailable']),
            'unit_price' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(10, 100),
        ];
    }

    private function generateUniqueProductId(): int
    {
        do {
            $productId = (int) ('22' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (product::where('product_id', $productId)->exists()); // Check for uniqueness in the database

        return $productId;
    }
}
