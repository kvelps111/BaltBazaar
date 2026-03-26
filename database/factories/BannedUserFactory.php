<?php

namespace Database\Factories;

use App\Models\BannedUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannedUserFactory extends Factory
{
    protected $model = BannedUser::class;

    public function definition(): array
    {
        return [
            'user_id'      => null,
            'phone_number' => '+371' . fake()->numerify('########'),
            'email'        => fake()->unique()->safeEmail(),
            'reason'       => fake()->randomElement(['Spam', 'Fraud', 'Inappropriate Content', 'Harassment', 'Multiple Violations']),
            'notes'        => fake()->optional()->sentence(),
            'banned_by'    => User::factory()->create(['is_admin' => true])->id,
        ];
    }
}