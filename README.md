# Laravel Widget Group

<p align="center">
<a href="https://travis-ci.org/Akopean/widgetss">
<img src="https://travis-ci.org/Akopean/widgets.svg?branch=master" alt="Build Status"></a>
</p>

![Widgets Screenshot](https://s3.eu-central-1.amazonaws.com/widget-group/widgets.png)


## [Documentation](doc/README.md)

## Configuration



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
  phpunit --coverage-html tests/coverage
