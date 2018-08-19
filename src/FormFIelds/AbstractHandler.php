<?php

namespace  Akopean\widgets\FormFields;

use Akopean\widgets\Traits\Renderable;

abstract class AbstractHandler
{
    use Renderable;

    public function handle($name, $id, $options, $dataContent = null)
    {
        $content = $this->createContent(
            $name,
            $id,
            $options,
            $dataContent
        );

        return $this->render($content);
    }
}
