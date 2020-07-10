<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Post::class, function (Faker $faker) {

    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);


    return [
        // 'name' => $faker->name,
        //
        'title' =>  $faker->title,
        'body'  =>  $faker->paragraphs(5,true),


    ];
});
