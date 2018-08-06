# Laravel Widget Group

<p align="center">
<a href="https://travis-ci.org/Akopean/widgetss">
<img src="https://travis-ci.org/Akopean/widgets.svg?branch=master" alt="Build Status"></a>
</p>

![Widgets Screenshot](https://s3.eu-central-1.amazonaws.com/widget-group/widgets.png)


## Installation Steps

### 1. Require the Package

After creating your new Laravel application you can include package with the following command: 

```
composer require akopean/widgets-group
```

#### config/app.php

> Only if you are on Laravel 5.4 will you need to [Add the Service Provider.](https://laravel.com/docs/5.6/providers)

```
// ... other service providers
Akopean\widgets\WidgetServiceProvider::class,
```

#### Then publish the configuration

```
php artisan vendor:publish
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

#### Create table Widget

```
php artisan migrate
```

### 2. Create routes

Somewhere in your routes file(s)

```
 \Akopean\widgets\Widget::routes();
```
or
```
Route::group(['prefix' => 'widget'], function () {
    \Akopean\widgets\Widget::routes();
});
```

## Configuration


....




## Additional Field Options

#### Find out how to use these additional details below:


##### Text and Number
```
'placeholder' => [
    'type' => 'text' || 'number',
    'placeholder' => 'text field'  || 'number field',
    'default' => 'Default text' || '0',
    'prepend' => '$',
    'append' => '.kg'
    
   'type' => 'text_area',
   'type' => 'rich_text_box',
   'type' => 'hidden',
   'type' => 'humber'
],
```
##### Text Area, Rich Text Box 
```
'placeholder' => [
    'type' => 'text_area' || 'rich_text_box',
    'placeholder' => 'text field',
    'default' => 'Default text' || 'Default rich text',  
],
```

##### File, Image 
```
'placeholder' => [
    'type' => 'file' || 'image',
      'placeholder' => ' ***** ',
      'min' => '12',//MB?
      'max' => '200',//MB?
      'file_types' => '.txt .jpg .png'?
  ],
```

  ## Other

  `Laravel Widget Group` based on following plugins or services:
```
  + [Laravel](https://laravel.com/)
  + [laravel-widgets](https://github.com/arrilot/laravel-widgets)
  + [toastr](http://codeseven.github.io/toastr/)
  + [sortable](https://github.com/RubaXa/Sortable)
  + [tinymce](https://github.com/tinymce)
  + [fine-uploader](https://github.com/FineUploader/fine-uploader)
  + [material-design-icons](https://material.io/tools/icons/?style=baseline)
  ```

   assets update
  php artisan vendor:publish --provider="Akopean\widgets\WidgetServiceProvider"
  php artisan vendor:publish --force --provider="Akopean\widgets\WidgetServiceProvider" --tag="config"
    
   test
  vendor\bin\phpunit
  vendor\bin\phpunit --coverage-html tests/coverage
