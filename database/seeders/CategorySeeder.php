<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
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
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
