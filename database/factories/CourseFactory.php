<?php

$factory->define(App\Course::class, function (Faker\Generator $faker) {
    return [
        "title" => $faker->name,
        "slug" => $faker->name,
        "descripition" => $faker->name,
        "price" => $faker->name,
        "start_date" => $faker->date("Y-m-d H:i:s", $max = 'now'),
        "published" => 0,
    ];
});
