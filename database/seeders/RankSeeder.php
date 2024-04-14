<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rank = new \App\Models\Rank();
        $rank->nameRank = "Rank 1";
        $rank->pointsRequired = 0;
        $rank->emojiRank = "";
        $rank->save();

        $rank = new \App\Models\Rank();
        $rank->nameRank = "Rank 2";
        $rank->pointsRequired = 1000;
        $rank->emojiRank = "";
        $rank->save();

        $rank = new \App\Models\Rank();
        $rank->nameRank = "Rank 3";
        $rank->pointsRequired = 2000;
        $rank->emojiRank = "";
        $rank->save();

    }
}
