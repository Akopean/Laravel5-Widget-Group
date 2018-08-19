<?php

namespace Akopean\widgets;



class Widgets{
 
	protected $widgets;
 

	public function __construct()
    {
		$this->widgets = config('widgets');
	}
 
     public static function routes()
    {
        require __DIR__.'/../routes/routes.php';
    }

    /**
     * @param $name options WidgetName
     * @param $id  options id WidgetField
     * @param $options  other Widget options
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function formField($name, $id, $options, $data)
    {
        $namespace = config('widgets.fields.' . $options['type'])['namespace'].'Handler';

        if(!$namespace || !class_exists($namespace)) {
            throw new \Exception('Wrong data in options fields =>' .$options['type']);
        }

        $formField = \App::make($namespace);

        return $formField->handle($name, $id, $options, $data);
    }

}