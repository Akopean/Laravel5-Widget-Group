<?php

namespace Akopean\widgets;

class Widget{
 
	protected $widgets;
 

	public function __construct(){
		$this->widgets = config('widgets');
	}
 
     public static function routes()
    {
        require __DIR__.'/../routes/routes.php';
    }

}