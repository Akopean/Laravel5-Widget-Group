<?php

namespace Akopean\Widgets;

class Widget{
 
 protected $widgets;
 

 public function __construct(){
    $this->widgets = config('widgets');
 }
}