<?php

namespace Akopean\widgets;


abstract class AbstractWidget extends \Arrilot\Widgets\AbstractWidget {

    //default namespace
    public $namespace = 'Akopean\widgets\Widgets';

    /**
     *  Возвращаем  массив полей   ['title' => 'textinput', '...' => 'checkbox']
     *  Поля предназначены для вывода/изменения информации в админ панели
     *  @return array
     */
    //abstract public function getField();
}