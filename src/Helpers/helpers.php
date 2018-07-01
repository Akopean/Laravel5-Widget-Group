<?php

if (!function_exists('widgets_asset')) {
    function widgets_asset($path, $secure = null)
    {
        return asset(config('widgets.assets_path').'/'.$path, $secure);
    }
}

if (!function_exists('_t')) {
    function _t($t, $default = '')
    {
        if (Lang::has($t))
        {
           return __($t);
        }

        return $default;
    }
}
