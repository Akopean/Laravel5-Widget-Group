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

    'models' => [
        //'namespace' => 'App\\',
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
        'asd' => [
            'namespace' => 'App\Widgets\TextWidget',
            'placeholder' => 'asdasdText Widget',
            'desc' => 'Arbitrary text.',
            'fields' => [
                'title' => [
                    'type' => 'text',
                ],
                'body' => [
                    'type' => 'rich_text_box',
                ],
            ]
        ],
        'TextWidget' => [
            'namespace' => 'App\Widgets\TextWidget',
            'placeholder' => 'Text Widget',
            'desc' => 'Arbitrary text.',
            'fields' => [
                'title' => [
                    'type' => 'text',
                ],
                'body' => [
                    'type' => 'text_area',
                ],
            ]
        ],
        'RecentNews' => [
            'namespace' => 'App\Widgets\RecentNews',
            'placeholder' => 'Recent News',
            'desc' => 'Arbitrary text.',
            'fields' => [
                'count' => [
                    'type' => 'number',
                ],
            ]
        ],
        'SocialLinks' => [
            'namespace' => 'App\Widgets\SocialLinks',
            'placeholder' => 'Social Links',
            'desc' => 'Arbitrary text.',
            'fields' => [
                'twitter' => [
                    'type' => 'text',
                ],
                'facebook' => [
                    'type' => 'text',
                ],
                'instagram' => [
                    'type' => 'text',
                ],
            ]
        ],
        'ContactInfo' => [
            'namespace' => 'App\Widgets\ContactInfo',
            'placeholder' => 'Contact Information',
            'desc' => 'Arbitrary text.',
            'fields' => [
                'contact_email' => [
                    'type' => 'text',
                ],
                'contact_phone' => [
                    'type' => 'text',
                ],
                'contact_address' => [
                    'type' => 'text',
                ],
                'contact_desc' => [
                    'type' => 'text',
                ],
            ]
        ],
    ],
];
