<?php

$factory->define(App\Section::class, function (Faker\Generator $faker) {
    return [
        "course_id" => factory('App\Course')->create(),
        "title" => $faker->name,
        "descripition" => $faker->name,
    ];
});
