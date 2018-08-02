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
        'namespace' => 'Akopean\\widgets\\Http\\Controllers',
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
         'namespace' => 'Akopean\widgets\Widgets',
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
        //'rules' => 'required|mimes:jpeg,jpg,png,svg | max:8192',
        'rules' => [
            'mimes' => 'jpg,jpeg,svg',
            'size' => [
                'min' => 1,
                'max' => 8192,
            ],
        ],
        'messages' => [
            'file.*.required' => 'Please upload an image',
            'file.*.mimes' => 'Only jpeg,png and svg images are allowed',
            'file.*.max' => 'Sorry! Maximum allowed size for an image is ...MB',
        ],
        'image' => [
            'path' => [
                'full_path' => 'widgets',
                'crop' => 'crop',
            ],
            'size' => [
             /*   'full_size' => [
                    'width' => 2048,
                    'height' => 1024,
                ],*/
                'icon_size' => [
                    'width' => 200,
                    'height' => 200,
                ],
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Path to the Widgets Assets
    |--------------------------------------------------------------------------
    |
    | Here you can specify the location of the widgets assets path
    |
    */

    'assets_path' => '/vendor/Akopean/widgets/assets',

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
        'inactive' => 'Inactive',
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
            'namespace' => 'Akopean\widgets\widgets\TextWidget',
            'placeholder' => 'Text Widget',
            'fields' => [
                'Text Field' => [
                    'type' => 'text',//*
                    'placeholder' => 'text field',
                    'default' => 'Default text',
                    'prepend' => '$',
                    'append' => '.kg',
                ],
                'Text Area Field' => [
                    'type' => 'text_area',//*
                    'default' => 'text area',
                    'placeholder' => 'text area',
                ],
                'Rich Area Field' => [
                    'type' => 'rich_text_box',//*
                    'default' => 'Default rich text box',
                ],
                'Number Field' => [
                    'type' => 'number',//*
                    'default' => '5',
                    'placeholder' => 'text field',//*
                    'prepend' => '$',
                    'append' => '.kg',
                ],
                'Checkbox' => [
                    'type' => 'checkbox',//*
                    "checked" => true, //*
                    'on' => "Activated",//* checked value
                    'off' => "Disabled",//* not checked value
                    'size' => 'normal', //large, normal, small, mini
                    'onstyle' => 'success', //default, primary, success, info, warning, danger
                    'offstyle' => 'warning', //default, primary, success, info, warning, danger
                    'width' => 200,

                ],
                'Radio' => [
                    'type' => 'radio',//*
                    "default" => "radio1",//*
                    "options" => [
                        "radio1" => "Radio Button 1 Text",
                        "radio2" => "Radio Button 2 Text",
                    ],
                ],
                'File' => [
                    'type' => 'file',
                    'min' => '1',//MB
                    'max' => '200',//MB
                    'multiple' => true, // default: false
                    'rules' => [
                        'mimes' => 'mp3,txt',
                        'size' => [
                            'min' => 1,
                            'max' => 2048,
                        ],
                    ],
                ],
                 'Image' => [
                     'type' => 'image',
                     'min' => '1',//MB
                     'max' => '200',//MB
                     'multiple' => true, // default: false
                     'rules' => [
                         'mimes' => 'jpg,jpeg,png,svg',
                         'size' => [
                             'min' => 1,
                             'max' => 2048,
                         ],
                     ],
                 /*    'crop' => [ ...
                         // original and icon don`t use for key
                         'middle' => [1024, 700], // [width, height]
                         'small' => [300, 300]
                     ]*/
                 ],
            ],
        ],
    ],
];
