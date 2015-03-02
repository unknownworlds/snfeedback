<?php

use Faker\Factory as Faker;

class FeedbackTicketsTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            FeedbackTicket::create([
                'unique_id'          => $faker->sha256(),
                'ip'                 => $faker->ipv4(),
                'cpu'                => $faker->word,
                'gpu'                => $faker->word,
                'ram'                => rand(1024, 1024 * 32),
                'os'                 => 'Windows',
                'position_x'         => $faker->randomFloat(),
                'position_y'         => $faker->randomFloat(),
                'position_z'         => $faker->randomFloat(),
                'orientation_w'      => $faker->randomFloat(),
                'orientation_x'      => $faker->randomFloat(),
                'orientation_y'      => $faker->randomFloat(),
                'orientation_z'      => $faker->randomFloat(),
                'mean_frame_time_30' => rand(1, 1000),
                'emotion'            => rand(1, 4),
                'text'               => $faker->paragraph(rand(1, 3)),
                'csid'               => rand(9000, 9999)
            ]);
        }
    }

}