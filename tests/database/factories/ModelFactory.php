<?php

$factory->define(\Akopean\widgets\Models\Widget::class, function (Faker\Generator $faker) {

    return [
        'name'  => key(config('widgets.widgets')),
        'group' => key(config('widgets.group')),
        'value' => ['id' => 1, 'test' => 'test'],
        'index' => 0,
    ];
});
