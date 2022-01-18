<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drinks')->insert([
            [
                'name' => 'Apple Juice',
                'category' => 'Juice',
                'picture' => 'apple_juice.jpg',
                'description' => 'This is apple juice',
                'quantity' => 50,
                'price' => 45000,
                'adultsonly' => 0
            ],
            [
                'name' => 'Orange Juice',
                'category' => 'Juice',
                'picture' => 'orange_juice.jpg',
                'description' => 'This is orange juice',
                'quantity' => 80,
                'price' => 50000,
                'adultsonly' => 0
            ],
            [
                'name' => 'Vodka',
                'category' => 'Alcohol',
                'picture' => 'vodka.jpg',
                'description' => 'This is vodka',
                'quantity' => 120,
                'price' => 175000,
                'adultsonly' => 1
            ],
            [
                'name' => 'Whiskey',
                'category' => 'Alcohol',
                'picture' => 'whiskey.jpg',
                'description' => 'This is whiskey',
                'quantity' => 55,
                'price' => 200000,
                'adultsonly' => 1
            ],
            [
                'name' => 'Champagne',
                'category' => 'Alcohol',
                'picture' => 'champagne.jpg',
                'description' => 'This is champagne',
                'quantity' => 125,
                'price' => 250000,
                'adultsonly' => 1
            ],
        ]);
    }
}
