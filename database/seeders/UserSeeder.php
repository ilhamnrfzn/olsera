<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'test@gmail.com',
            'name' => 'Ilham',
            'password' => \Hash::make('12345678'),
            'status' => 'active',
        ]);
    }
}
