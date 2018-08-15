<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Book::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title,
        'file' => $faker->word . '.epub',
        'md5' => $faker->md5,
        'image' => $faker->imageUrl(),
        'is_public' => $faker->boolean,
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Page::class, function (Faker\Generator $faker) {
    return [
        'book_id' => $faker->numberBetween(1, 10000),
        'title' => $faker->title,
        'url' => $faker->word . '.html',
    ];
});

$factory->define(App\UserBook::class, function (Faker\Generator $faker) {
    return [
        'book_id' => $faker->numberBetween(1, 10000),
        'user_id' => $faker->numberBetween(1, 10000)
    ];
});
