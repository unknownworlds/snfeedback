<?php

// This file is provided under The MIT License as part of the Subnautica feedback system
// Copyright (c) 2015 Unknown Worlds Entertainment Inc.
// Please see the included LICENSE.txt for additional information.

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