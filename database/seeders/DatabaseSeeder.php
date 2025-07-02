<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
//    public function run(): void
//    {
//        // User::factory(10)->create();
//
//        DB::table('users')->insert([
//            'name' => Str::random(10),
//            'email' => Str::random(10).'@example.com',
//            'password' => Hash::make('password'),
//        ]);
//    }

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);
    }
}
