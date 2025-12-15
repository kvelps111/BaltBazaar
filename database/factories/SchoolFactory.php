<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition(): array
    {
        $regions = ['Rīga', 'Pierīga', 'Vidzeme', 'Kurzeme', 'Zemgale', 'Latgale'];
        $types = ['Vidusskola', 'Valsts ģimnāzija', 'Privāta augstskola', 'Augstskola'];
        
        return [
            'name' => fake()->randomElement([
                'Rīgas Valsts 1. ģimnāzija',
                'Daugavpils Valsts ģimnāzija',
                'Jelgavas Valsts ģimnāzija',
                'Liepājas Valsts ģimnāzija',
                'Cēsu Valsts ģimnāzija',
                'Balvu Valsts ģimnāzija',
                'Babītes vidusskola',
                'Austrumlatvijas Tehnoloģiju vidusskola',
                'Biznesa augstskola Turība',
            ]),
            'region' => fake()->randomElement($regions),
            'type' => fake()->randomElement($types),
        ];
    }
}