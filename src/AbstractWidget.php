<?php

namespace Akopean\laravel5WidgetsGroup;


abstract class AbstractWidget extends \Arrilot\Widgets\AbstractWidget {

    //default namespace
    public $namespace = 'Akopean\laravel5WidgetsGroup\Widgets';

    /**
     *  Возвращаем  массив полей   ['title' => 'textinput', '...' => 'checkbox']
     *  Поля предназначены для вывода/изменения информации в админ панели
     *  @return array
     */
    //abstract public function getField();
}