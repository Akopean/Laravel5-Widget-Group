<?php

namespace Akopean\laravel5WidgetsGroup;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use League\Flysystem\Exception;

class File extends BaseFile
{
    public function upload(Request $request)
    {
        $path = [];
        foreach ($request->file() as $value => $file) {

            $f = Storage::disk($this->filesystem)->put($this->slug, $file);

            $path[$value] = $f;
        }
        return $path;
    }
}