<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'nik'=> $faker->randomNumber(9),
        'full_name'=> "{$faker->firstName} {$faker->lastName}",
        'mobile_phone'=> $faker->phoneNumber,
        'full_address'=> $faker->address,
        'department_id'=> Department::query()->inRandomOrder()->first()->id,
    ];
});
