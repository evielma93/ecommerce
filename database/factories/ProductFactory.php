<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $categoryPicture = $faker->randomElement(['business', 'technics', 'city']);
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'picture' => \Faker\Provider\Image::image(storage_path() . '/app/public/products', 600, 350, $categoryPicture, false),
        'price' => $faker->randomFloat(2, 5, 30),
        'created_at' => now()
    ];
});
