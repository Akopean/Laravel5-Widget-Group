<?php

$factory->define(\Akopean\widgets\Models\Widget::class, function (Faker\Generator $faker) {

    return [
        'name'    => $faker->name,
        'group'   => $faker->name('leftSidebar'),
        'value' => json_decode(['id' => 1, 'Text' => 'text']),
        'index' => 1,
    ];
});
