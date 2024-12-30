<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Team::factory()->create([
            'user_id' => 1,
            'name' => 'Rafaela \'s Team',
            'personal_team' => 1,
        ]);
    }
}
