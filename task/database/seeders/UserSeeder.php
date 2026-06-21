<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name'=>'Mohamed Ragab',
        //     'email'=>'mohamed@example.com',
        //     'password'=>'123456789'
        // ]);
        User::factory()->count(1000)->create();
    }
}
