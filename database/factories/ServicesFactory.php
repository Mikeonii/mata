<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Service::class, function (Faker $faker) {
    return [
        'contract_no' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'date' => $faker->date(),
        'name' =>$faker->name(),
        'name_of_deceased' => $faker->name(),
        'address' => $faker->address(),
        'amount' => $faker->numberBetween($min=1000,$max=2000),
        'branch' => $faker->randomDigit(),
        'phone_number'=> $faker->phoneNumber(),
        'down_payment' =>$faker->numberBetween($min=1000,$max=2000),
        'balance' =>$faker->numberBetween($min=1000,$max=2000),

    ];
});


// $table->string('name');
//         $table->string('contact_number');
//         $table->string('name_of_deceased');
//         $table->string('address');
//         $table->integer('amount');