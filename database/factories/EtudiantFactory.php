<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Etudiant;
use Faker\Generator as Faker;

$factory->define(Etudiant::class, function (Faker $faker) {
    return [
        'nom' => $faker->firstName,
        'prenom' => $faker->lastName,
        'ville' => $faker->city,
        'phone_1' => $faker->phoneNumber,
        'phone_2' => $faker->phoneNumber,
        'id_niveau' => "1"
    ];
});
