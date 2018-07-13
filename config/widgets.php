<?php
/*
 * Ключ: краткое название виджета для обращения к нему из шаблона
 * Значение: название класса виджета с пространством имен
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Controllers config
    |--------------------------------------------------------------------------
    |
    | Here you can specify voyager controller settings
    |
    */

    'controllers' => [
        'namespace' => 'Akopean\\laravel5WidgetsGroup\\Http\\Controllers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Models config
    |--------------------------------------------------------------------------
    |
    | Here you can specify default model namespace ...
    |
    */

    /* 'models' => [
         'namespace' => 'Akopean\laravel5WidgetsGroup\Widgets',
     ],
 */
    /*
    |--------------------------------------------------------------------------
    | Storage Config
    |--------------------------------------------------------------------------
    |
    | Here you can specify attributes related to your application file system
    |
    */

    'storage' => [
        'disk' => 'public',
        'slug' => 'widgets',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Configuration
    |--------------------------------------------------------------------------
    |
    */
    'file' => [
        // Valid file mimes and size for uploading
        'rules' => 'required|mimes:jpeg,jpg,png,svg | max:8192',
        'messages' => [
            'file.*.required' => 'Please upload an image',
            'file.*.mimes' => 'Only jpeg,png and bmp images are allowed',
            'file.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
        ],
    ],

    'image' => [
        'path' => [
            'full_path' => 'widgets/',
            'icon_path' => 'widgets/icon/',
        ],
        'size' => [
            'full_size' => 2048,
            'icon_size' => 200
        ]
    ],
    /*
    |--------------------------------------------------------------------------
    | Path to the Widgets Assets
    |--------------------------------------------------------------------------
    |
    | Here you can specify the location of the widgets assets path
    |
    */

    'assets_path' => '/vendor/Akopean/laravel5WidgetsGroup/assets',

    /*
    |--------------------------------------------------------------------------
    | Widgets Group
    |--------------------------------------------------------------------------
    |
    |
    */

    'group' => [
        'leftSidebar' => 'Left Sidebar',
        'rightSidebar' => 'Right Sidebar',
        'footer' => 'Footer',
        'after_header' => 'After Header',
        'inactive' => 'asdad'
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Widgets config
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'widgets' => [
        'TextWidget' => [
            'namespace' => 'Akopean\laravel5WidgetsGroup\widgets\TextWidget',
            'placeholder' => 'Text Widget',
            'fields' => [
                'title' => [
                    'type' => 'text',
                    'placeholder' => 'text field',
                    'default' => 'Default text',
                    'prepend' => '$',
                    'append' => '.kg',
                ],
                /*    'body' => [
                       'type' => 'text_area',
                       'default' => 'text area',
                       'placeholder' => 'text area',
                   ],
                   'bodys1' => [
                       'type' => 'rich_text_box',
                       'default' => 'Default rich text box',
                   ],
                   'number' => [
                       'type' => 'number',
                       'default' => '5',
                       'placeholder' => 'text field',
                       'prepend' => '$',
                       'append' => '.kg'
                   ],*/
                'f' => [
                    'type' => 'file',
                    'min' => '1',//MB
                    'max' => '200',//MB
                    'multiple' => true, // default: false
                    'rules' => 'mimes:txt | max:2048',
                ],
              /*  'i' => [
                    'type' => 'image',
                    'min' => '1',//MB
                    'max' => '200',//MB
                    'multiple' => true, // default: false
                    'rules' => 'mimes:jpeg,jpg | max:2048',
                    'size' => [
                        'full_size' => 1024
                    ]
                ],*/
            ],
        ],
    ],
];

/*            $allowedImageMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/bmp',
                'image/svg+xml',
            ];
*/