<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'id' => (string) Str::uuid(), // Generate a unique UUID for `id`
            'user_id' => $this->generateCustomUserId(), // Generate a 6-digit ID starting with 11
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => strtolower($firstName) . '.' . strtolower($lastName),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Default password
            'address' => $this->faker->address(),
            'contact' => $this->faker->phoneNumber(),
            'profile_picture' => $this->faker->imageUrl(200, 200, 'people', true, 'Profile Picture'),
            'status' => $this->faker->randomElement(['Active', 'Inactive', 'Pending']),
            'company' => $this->faker->company(),
            'email_verified_at' => $this->faker->optional()->dateTime(),
        ];
    }

    /**
     * Generate a 6-digit user_id starting with "11" and randomize the remaining digits.
     */
    private function generateCustomUserId(): int
    {
        do {
            $userId = (int) ('11' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT));
        } while (User::where('user_id', $userId)->exists()); // Check for uniqueness in the database

        return $userId;
    }
}
