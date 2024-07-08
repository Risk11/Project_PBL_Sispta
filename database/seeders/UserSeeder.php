<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::create([
            'name'=> 'Admin Aplikasi',
            'level'=>'admin',
            'email'=>'admin@admin',
            'password'=>bcrypt('admin'),
            'remember_token'=> Str::random(68),
        ]);
    }
}
