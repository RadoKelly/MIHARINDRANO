<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
        'name' => 'ranto',
        'email' => 'ranto@gmail.com',
        'password' => bcrypt('a'), 
    ]);
}
}