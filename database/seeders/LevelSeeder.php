<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $level = new \App\Models\Level();
        $level->nameLevel = "Level 1";
        $level->pointsEarned = 1000;
        $level->save();

        $level = new \App\Models\Level();
        $level->nameLevel = "Level 2";
        $level->pointsEarned = 2000;
        $level->save();

        $level = new \App\Models\Level();
        $level->nameLevel = "Level 3";
        $level->pointsEarned = 3000;
        $level->save();
    }
}
