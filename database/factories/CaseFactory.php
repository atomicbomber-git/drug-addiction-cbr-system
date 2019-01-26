<?php

use Faker\Generator as Faker;

$factory->define(App\CaseRecord::class, function (Faker $faker) {
    return [
        'stage' => $faker->randomElement(App\CaseRecord::STAGES),
        'solution' => implode(" ", $faker->paragraphs),
        'recommendation' => implode(" ", $faker->paragraphs)
    ];
});
