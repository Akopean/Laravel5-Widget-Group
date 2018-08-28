# Installation Steps

### 1. Require the Package

After creating your new Laravel application you can include package with the following command: 

```php
composer require akopean/widgets
```


#### config/app.php

> Only if you are on Laravel 5.4 will you need to [Add the Service Provider.](https://laravel.com/docs/5.6/providers)

```php
// ... other service providers
Akopean\widgets\WidgetServiceProvider::class,
```

#### Then publish the configuration

```php
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

### 3. Create routes

Somewhere in your routes file(s)

```php
 \Akopean\widgets\Widgets::routes();
```
or
```php
Route::group(['prefix' => 'widget'], function () {
    \Akopean\widgets\Widgets::routes();
});
```

