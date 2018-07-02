# Laravel Widget Group

## Installation Steps

### 1. Require the Package

After creating your new Laravel application you can include package with the following command: 

```bash
composer require *****
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Additional Field Options

### Find out how to use these additional details below:


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

  Akopean\laravel5WidgetsGroup\WidgetServiceProvider
  
  composer require Akopean/laravel5-widgets-group:dev-master --prefer-source
  
  php artisan vendor:publish --provider="Akopean\laravel5WidgetsGroup\WidgetServiceProvider"
  
  php artisan vendor:publish --force --provider="Akopean\laravel5WidgetsGroup\WidgetServiceProvider" --tag="config"