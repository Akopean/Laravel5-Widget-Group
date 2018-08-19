## Additional Field Options

#### Find out how to use these additional details below:


##### Text and Number
```php
'unique_id' => [
    'type' => 'text' || 'number',
    'title' => 'Title', //* title
    'placeholder' => 'text field'  || 'number field',
    'default' => 'Default text' || '0',
    'prepend' => '$',
    'append' => '.kg'
],
```

##### Text Area
```php
'unique_id' => [
    'title' => 'Title Area', //* title
    'type' => 'text_area',
    'placeholder' => 'text field',
    'default' => 'Default text',  
    'rows' => 6, //area rows  default 4
],
```

##### Rich Text Box 
```php
'unique_id' => [
    'title' => 'Title Area', //* title
    'type' => 'rich_text_box',
    'default' => 'Default rich text',  
],
```

##### Checkbox 
```php
'unique_id' => [ // unique
    'type' => 'checkbox',
    'checked' => true,
    'title' => 'Checkbox', 
    'on' => "Activated", //* checked value
    'off' => "Disabled", //* not checked value
    'size' => 'normal', //large, normal, small, mini
    'onstyle' => 'success', //default, primary, success, info, warning, danger
    'offstyle' => 'warning', //default, primary, success, info, warning, danger
    'width' => 200,
],
```

##### Radio Button
```php
'unique_id' => [
    'type' => 'radio',//*
    'title' => 'Radio', //* unique
    "default" => "radio1",//*
    "options" => [//*
        "radio1" => "Radio Button 1 Text",//*
        "radio2" => "Radio Button 2 Text",//*
    ],
],
```

##### File
```php
'unique_id' => [
    'type' => 'file', //*
    'title' => 'File', //* unique
    'min' => '1',//MB
    'max' => '200',//MB
    //'multiple' => true, // default: false  <- etc
    'rules' => [
        'mimes' => 'mp3,txt',
        'size' => [
            'min' => 1,
            'max' => 2048,
        ],
    ],
],
```

##### Image
```php

'unique_id' => [//* unique
     'type' => 'image', //*
      'title' => 'Image',
      'min' => '1',//MB
      'max' => '200',//MB
      //'multiple' => true, // default: false <- etc
      'rules' => [
          'mimes' => 'jpg,jpeg,png',
          'size' => [
                'min' => 1,
                'max' => 2048,
         ],
    ],
    /*'crop' => [  <- etc
        //original and icon don`t use for key
        'middle' => [1024, 700], // [width, height]
        'small' => [300, 300]
    ]*/
],
```

##### Google Map
###### Add in config/widget.php your google key and start cords and zoom
```php
'unique_id' => [ // id* unique  // out  google_map_id -> field,  cord_google_map_id ->  cord google map
    'type' => 'google_map',//*
    'title' => 'Google Map', //* title
],
```