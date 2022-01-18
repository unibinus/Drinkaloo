<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('carts')->insert([
            [
                'drink_id' => 1,
                'user_id' => 1,
                'quantity' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'drink_id' => 3,
                'user_id' => 1,
                'quantity' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'drink_id' => 2,
                'user_id' => 2,
                'quantity' => 1,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }
}
