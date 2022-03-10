<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use App\Models\Unit;
use App\Models\Warehouse;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'code'=> $faker->randomNumber(9, true),
        'name'=> $faker->words(2, true),
        'quantity'=> $faker->numberBetween(1, 100),
        'description'=> $faker->words(4, true),
        'unit_id'=> Unit::query()->inRandomOrder()->first()->id,
        'warehouse_id'=> Warehouse::query()->inRandomOrder()->first()->id,
    ];
});
