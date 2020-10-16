<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'FirstName',
            'last_name' => 'LastName',
            //'email' => $this->faker->unique()->safeEmail,
            'email' => 'test@gmail.com',
            'password' => Hash::make('test'),
            'city' => 'Bankok',
            'status' => 1
        ]);
    }
}
