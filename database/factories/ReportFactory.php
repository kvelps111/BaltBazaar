<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'listing_id'  => Listing::factory(),
            'user_id'     => User::factory(),
            'reason'      => fake()->randomElement([
                'Krāpšana',
                'Neatbilstošs saturs',
                'Nepareiza kategorija',
                'Dublikāts',
                'Cits',
            ]),
            'description' => fake()->optional()->sentence(),
            'status'      => fake()->randomElement(['pending', 'reviewed', 'resolved', 'dismissed']),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function resolved(): static
    {
        return $this->state(['status' => 'resolved']);
    }
}