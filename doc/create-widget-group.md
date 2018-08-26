# Create New Widget Group

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

####Open config/widgets.php and add new widget to widgets
```php
    /*
    |--------------------------------------------------------------------------
    | Custom Widgets config
    |--------------------------------------------------------------------------
    |
    */
    'widgets' => [
        'WidgetName' => [
            'namespace' => 'app\Widgets\WidgetName',
            'placeholder' => 'Widget Name',
            'fields' => [
                'name' => [ 
                    'type' => 'text',
                    'title' => 'Some Name',
                    'placeholder' => 'name ...',
                ],
             ],
        ],
    ],
```

####Open app/Widgets/WidgetName, change 
```php
class WidgetName extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    //Widget Data
    protected $data;
    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->data = $config['data'];
        unset($config['data']);

        parent::__construct($config);
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        dd($this->data);
        ...
    }
}
```

###The last step is to call the widget group.
```php
@WidgetGroup('groupName')
```
####groupName - group name in config/widgets.php 
```php
    'group' => [
        'groupName' => 'Group Title',
    ],
```
