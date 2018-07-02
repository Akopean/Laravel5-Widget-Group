<?php

namespace Akopean\laravel5WidgetsGroup;

class BaseFile
{
    /** @var string */
    protected $filesystem;

    protected $slug;

    /** @var string */
    private $directory = '';

    public function __construct()
    {
        $this->filesystem = config('widgets.storage.disk', 'public');
        $this->slug = config('widgets.storage.slug', 'widgets');
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;
    }
}