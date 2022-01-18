<?php

namespace Database\Seeders;

use App\Models\role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run(){
        DB::table('users')->insert([
        [
            'username' => 'users1',
            'role_id' => 2,
            'fullName' => 'Budi Sukses',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 2,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],

        [
            'username' => 'users2',
            'role_id' => 2,
            'fullName' => 'Tintin Sutintin',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 0,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],

        [
            'username' => 'admin1',
            'role_id' => 1,
            'fullName' => 'Jajang Sujajang',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 0,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],
        [
            'username' => 'admin2',
            'role_id' => 1,
            'fullName' => 'Dedeng Sudedeng',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 0,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],
        [
            'username' => 'Jorjis',
            'role_id' => 2,
            'fullName' => 'George',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 2,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],
        [
            'username' => 'usertest1',
            'role_id' => 2,
            'fullName' => 'Testing',
            'password' => Hash::make('password'),
            'profilePic' => 'public/images/pic1.jpg',
            'level' => 2,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ],
        ]);
     }
}
