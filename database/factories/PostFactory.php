<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Post::class, function (Faker $faker) {

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);


    return [
        // 'name' => $faker->name,
        //
        'title' =>  $faker->sentence,
        'body'  =>  $faker->paragraphs(5,true),
        'reply_count' => random_int(1,20),
        'view_count'  => random_int(20,100),
        'updated_at'  => $updated_at,
        'created_at'  => $created_at,
    ];
});
