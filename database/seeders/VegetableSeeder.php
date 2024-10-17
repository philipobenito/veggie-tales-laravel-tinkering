<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vegetable;
use App\Models\VegetableClassification;

class VegetableSeeder extends Seeder
{
    public function run(): void
    {
        $classifications = ['Root', 'Leafy', 'Fruit', 'Legume', 'Bulb', 'Stem'];

        foreach ($classifications as $classification) {
            VegetableClassification::create(['name' => $classification]);
        }

        Vegetable::factory()->count(50)->create()->each(function ($vegetable) {
            $classification = VegetableClassification::inRandomOrder()->first();
            $vegetable->classification_id = $classification->id;
            $vegetable->save();
        });
    }
}
