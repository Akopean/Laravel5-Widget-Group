<?php

namespace Akopean\laravel5WidgetsGroup\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    private $configPath = 'widgets.widgets.';


    /**
     * Get Widget config options
     * @return \Illuminate\Config\Repository|mixed|null
     */
    public function getOptions() {
        if (config($this->configPath . $this->name)) {
            return config($this->configPath . $this->name);
        }
        return null;
    }

    /**
     * @param $field
     * @return \Illuminate\Config\Repository|mixed|null
     */
    public function getFieldOptions($field) {
        if (config($this->configPath  . $this->name . '.fields.' . $field)) {
            return config($this->configPath  . $this->name . '.fields.' . $field);
        }
        return null;
    }
}
