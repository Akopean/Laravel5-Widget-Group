<?php

namespace  Akopean\widgets\FormFields;

class TextHandler extends AbstractHandler
{
    protected $codename = 'text';

    /**
     * @param $name
     * @param $id
     * @param $options
     * @param null $dataContent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createContent($name, $id, $options, $dataContent = null)
    {
        return view('widgets::formfields.text', [
            'name'        => $name,
            'id'         => $id,
            'options'     => $options,
            'dataContent' => $dataContent,
        ]);
    }
}
