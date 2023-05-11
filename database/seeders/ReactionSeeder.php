<?php

namespace Database\Seeders;

use App\Models\Reaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->getDefaultReactions()
            ->each(function ($reaction) {
                Reaction::create($reaction);
            });
    }

    public function getDefaultReactions(): Collection
    {
        return collect([
            [
                'name' => 'Like',
                'icon' => 'like.png',
                'color' => '#4ade80',
            ],
            [
                'name' => 'Dislike',
                'icon' => 'dislike.png',
                'color' => '#f87171',
            ]
        ]);
    }
}
