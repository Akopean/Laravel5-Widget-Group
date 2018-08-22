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
    | Here you can specify widgets controller settings
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
    | Google Map Config data
    |--------------------------------------------------------------------------
    |
    | Here you can add your google key or change map zoom or change start map cords ...
    |
    */
    'googlemaps' => [
        'key' => env('GOOGLE_MAPS_KEY', ''),
        'center' => [
            'lat' => env('GOOGLE_MAPS_DEFAULT_CENTER_LAT', '50.431782'),
            'lng' => env('GOOGLE_MAPS_DEFAULT_CENTER_LNG', '30.516382'),
        ],
        'zoom' => env('GOOGLE_MAPS_DEFAULT_ZOOM', 8),
    ],

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
            'file.*.mimes' => 'This mimes does not allowed',
            'file.*.max' => 'Sorry! Maximum allowed size for an image is ...MB',
        ],
        'image' => [
            'path' => [
              //  'full' => 'widgets',
                'icon' => 'icon',
            ],
            'size' => [
                'icon' => [
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

    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets Inactive Group
    |--------------------------------------------------------------------------
    |
    |
    */
    'inactive_group' => [
        'inactive' => 'Inactive',
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets Fields Type
    |--------------------------------------------------------------------------
    |
    |
    */
    'fields' => [
        'text' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'number' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'text_area' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'reach_text_box' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'checkbox' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'radio' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'file' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'image' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
        'google_map' => [
            'namespace' => 'Akopean\widgets\FormFields\Base',
        ],
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
                'google_map_id' => [ // id* unique  // out  google_map_id -> field,  cord_google_map_id ->  cord google map
                    'type' => 'google_map',//*
                    'title' => 'Google Map', //* title
                ],
                'unique_text_id' => [ // id* unique
                    'type' => 'text',//*
                    'title' => 'Text Field', //* title
                    'placeholder' => 'text field',
                    'default' => 'Default text',
                    'prepend' => '$',
                    'append' => '.kg',
                ],
                'unique_text_area_id' => [ // id* unique
                    'title' => 'Text Area Field', //* title
                    'type' => 'text_area',//* field type
                    'default' => 'text area', // default data
                    'placeholder' => 'text area', // input placeholder
                    'rows' => 6, //area rows  default 4
                ],
                'unique_reach_area_id' => [// id* unique
                    'title' => 'Reach Area Field', //* title
                    'type' => 'reach_text_box',//*
                    'default' => 'Default reach text box',
                ],
                'unique_number_id' => [//* unique
                    'type' => 'number',//*
                    'title' => 'Number Field',  //* title
                    'default' => '5',
                    'placeholder' => 'text field',//*
                    'prepend' => '$',
                    'append' => '.kg',
                ],
                'unique_checked_id' => [ //* unique
                    'type' => 'checkbox',//*
                    "checked" => true, //*
                    'title' => 'Checkbox',
                    'on' => "Activated",//* checked value
                    'off' => "Disabled",//* not checked value
                    'size' => 'normal', //large, normal, small, mini
                    'onstyle' => 'success', //default, primary, success, info, warning, danger
                    'offstyle' => 'warning', //default, primary, success, info, warning, danger
                    'width' => 200,
                ],
                'unique_radio_id' => [
                    'type' => 'radio',//*
                    'title' => 'Radio', //* unique
                    "default" => "radio1",//*
                    "options" => [
                        "radio1" => "Radio Button 1 Text",
                        "radio2" => "Radio Button 2 Text",
                    ],
                ],
                'unique_file_id' => [
                    'type' => 'file', //*
                    'title' => 'File', //* unique
                    'min' => '1',//MB
                    'max' => '200',//MB
                   // 'multiple' => true, // default: false
                    'rules' => [
                        'mimes' => 'mp3,txt',
                        'size' => [
                            'min' => 1,
                            'max' => 2048,
                        ],
                    ],
                ],
                'unique_image_id' => [//* unique
                    'type' => 'image', //*
                    'title' => 'Image',
                    'min' => '1',//MB
                    'max' => '200',//MB
                 //   'multiple' => true, // default: false
                    'rules' => [
                        'mimes' => 'svg,png,jpg,jpeg',
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
