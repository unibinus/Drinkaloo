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
                'quantity' => 50,
                'price' => 45000,
                'adultonly' => 0
            ],
            [
                'name' => 'Orange Juice',
                'category' => 'Juice',
                'picture' => 'orange_juice.jpg',
                'quantity' => 80,
                'price' => 50000,
                'adultonly' => 0
            ],
            [
                'name' => 'Vodka',
                'category' => 'Alcohol',
                'picture' => 'vodka.jpg',
                'quantity' => 120,
                'price' => 175000,
                'adultonly' => 1
            ],
            [
                'name' => 'Whiskey',
                'category' => 'Alcohol',
                'picture' => 'whiskey.jpg',
                'quantity' => 55,
                'price' => 200000,
                'adultonly' => 1
            ],
            [
                'name' => 'Champagne',
                'category' => 'Alcohol',
                'picture' => 'champagne.jpg',
                'quantity' => 125,
                'price' => 250000,
                'adultonly' => 1
            ],
        ]);
    }
}
