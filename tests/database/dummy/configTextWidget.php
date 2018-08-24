<?php

return [
    'TestWidget' => [
        'namespace' => 'Akopean\widgets\Tests\stubs\TestWidget',
        'placeholder' => 'Test Widget',
        'fields' => [
            'unique_text_id' => [
                'type' => 'text',//*
                'title' => 'Test Field',
                'placeholder' => 'Test Field',
                'default' => 'Default test text',
                'prepend' => '$',
                'append' => '.kg',
            ],

            'File' => [
                'type' => 'file', //*
                'title' => 'File', //* unique
            ],
            'Image' => [//* unique
                'type' => 'image', //*
                'title' => 'Image',
                'rules' => [
                    'mimes' => 'svg,png,jpg,jpeg',
                    'size' => [
                        'min' => 1,
                        'max' => 2048,
                    ],
                ],
            ],
        ],
    ],
];
