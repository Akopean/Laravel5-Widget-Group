# Create New Widget

### Create Widget
```php
php artisan make:widget WidgetName
```

###This command generates two files:

```php
resources/views/widgets/widget_name.blade.php is an empty view.
```
Add "--plain" option if you do not need a view.
```php
app/Widgets/WidgetName is a widget class.
```

###The last step is to call the widget.

```php
@widget('widgetName')
```