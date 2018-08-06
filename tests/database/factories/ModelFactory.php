<?php

$factory->define(\Akopean\widgets\Models\Widget::class, function (Faker\Generator $faker) {

    return [
        'name'  => 'TextWidget',
        'group' => 'fake_group',
        'value' => ['id' => 1, 'test' => 'test'],
        'index' => 1,
    ];
});
