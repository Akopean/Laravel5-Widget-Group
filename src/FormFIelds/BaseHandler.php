<?php

namespace  Akopean\widgets\FormFields;

class BaseHandler extends AbstractHandler
{

    /**
     * @param $name
     * @param $id
     * @param $options
     * @param null $dataContent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createContent($name, $id, $options, $dataContent = null)
    {
        return view('widgets::formfields.' . $options['type'], [
            'name'        => $name,
            'id'         => $id,
            'options'     => $options,
            'dataContent' => $dataContent,
        ]);
    }
}
