<?php

use Faker\Factory as Faker;

class FeedbackCategoriesTableSeeder extends Seeder
{
    private $categories = [
        'general',
        'gameplay',
        'bug',
        'framerate'
    ];

    public function run()
    {
        foreach ($this->categories as $k => $v) {
            FeedbackCategory::create([
                'name' => $v
            ]);
        }
    }

}