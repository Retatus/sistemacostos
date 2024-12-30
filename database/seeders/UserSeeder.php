<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Renato',
            'email' => '7rguevara@gmail.com',
            'password' => Hash::make('Hola1234@')

        ]);
        $admin->assignRole('admin');

        $editor = User::create([
            'name' => 'Andres',
            'email' => 'andres@example.com',
            'password' => Hash::make('Hola1234@')
        ]);        
        $editor->assignRole('editor');
    }
}
