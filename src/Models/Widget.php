<?php

namespace Akopean\laravel5WidgetsGroup\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $value
 */
class Widget extends Model
{
    private $configPath = 'widgets.widgets.';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'array',
       // 'created_at' => 'datetime:Y-m-d',
    ];

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
