<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('users')->delete();
        DB::collection('users')->insert(['name' => 'John Doe', "email"=> "jhon@gmail.com","password"=>bcrypt("password"), 'seed' => true]);
    }
}
