<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    return [
        // 'name' => $faker->name,
        'content' => $faker->paragraph(3),
        'created_at' => $faker->dateTimeBetween('-30 day','-10 day'),
        'updated_at' => $faker->dateTimeBetween('-10 day','-2 day'),
    ];
});
