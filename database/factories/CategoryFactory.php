<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Elektronika',
                'Grāmatas un mācību materiāli',
                'Apģērbi',
                'Apavi',
                'Mēbeles un interjers',
                'Sports un brīvā laika piederumi',
                'Velosipēdi un skrejriteņi',
                'Video Spēles un Galda spēles',
                'Mūzikas instrumenti',
                'Datortehnika un piederumi',
                'Telefoni un aksesuāri',
                'Sadzīves tehnika',
                'Kosmētika un kopšanas līdzekļi',
                'Biļetes un pasākumi',
                'Auto',
                'Auto piederumi',
                'Cits',
            ]),
        ];
    }
}