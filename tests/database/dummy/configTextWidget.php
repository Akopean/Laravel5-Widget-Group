<?php

return [
    'TestWidget' => [
        'namespace' => 'Akopean\widgets\Tests\stubs\TestWidget',
        'placeholder' => 'Test Widget',
        'fields' => [
            'Test Field' => [
                'type' => 'text',//*
                'id' => 'unique_test_id', //* unique
                'placeholder' => 'Test Field',
                'default' => 'Default test text',
                'prepend' => '$',
                'append' => '.kg',
            ],
        ],
    ],
];