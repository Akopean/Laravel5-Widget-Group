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
        'slug' => 'widgets'
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
                    'append' => '.kg'
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
                'filesadfhfh' => [
                    'type' => 'file',
                    'min' => '12',//MB
                    'max' => '200',//MB
                    'file_types' => '.txt .jpg .png',
                ],
                'filefhfh' => [
                    'type' => 'file',
                    'min' => '12',//MB
                    'max' => '200',//MB
                    'file_types' => '.txt .jpg .png',
                ],
            ]
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