<?php

use Illuminate\Database\Seeder;
use App\Reaction;

class ReactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = "reactions";
        Reaction::firstOrCreate([
            "name" => "Like",
            "image_uri" => $path . "/like.png"
        ]);
        Reaction::firstOrCreate([
            "name" => "Love",
            "image_uri" => $path . "/love.png"
        ]);
        Reaction::firstOrCreate([
            "name" => "Diskile",
            "image_uri" => $path . "/dislike.png"
        ]);
    }
}
