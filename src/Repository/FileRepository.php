<?php

namespace Akopean\laravel5WidgetsGroup\Repository;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Akopean\laravel5WidgetsGroup\Models\Widget;


class FileRepository
{
    /**
     * @param Array $form_data
     * @param Widget $widget
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload($form_data, $widget)
    {
       $key = array_keys($form_data)[0];
        $field_options = $widget->getFieldOptions($key);
        dd($key);
        $validator = Validator::make($form_data, [$key . '.*' => \config('widgets.file.rules')],
            \config('widgets.file.messages'));

        if ($validator->fails()) {

            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400,
            ], 400);
        }



        $value = [];
        $file_count = count($form_data['file']);
        for ($i = 0; $i < $file_count; $i++) {
            $file = $form_data['file'][$i];
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);

            $filename = $this->sanitize($originalNameWithoutExt);
            $allowed_filename = $this->createUniqueFilename($filename, $extension);

            $uploadSuccess1 = $this->original($file, $allowed_filename);

            $uploadSuccess2 = $this->icon($file, $allowed_filename);
            $value[$i] = ['original' => $uploadSuccess1, 'icon' => $uploadSuccess2];

            if (!$uploadSuccess1 || !$uploadSuccess2) {

                return Response::json([
                    'error' => true,
                    'message' => 'Server error while uploading',
                    'code' => 500,
                ], 500);

            }
        }
        dd($value);
        $sessionImage = new Widget;
        $sessionImage->filename = $allowed_filename;
        $sessionImage->original_name = $originalName;
        $sessionImage->save();

        return Response::json([
            'error' => false,
            'code' => 200,
        ], 200);

    }

    public function createUniqueFilename($filename, $extension)
    {
        $full_path_dir = \config('widgets.image.path.full_path');
        $full_image_path = $full_path_dir . $filename . '.' . $extension;

        if (File::exists($full_image_path)) {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);

            return $filename . '-' . $imageToken . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Optimize Original Image
     */
    public function original($photo, $filename)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(\config('widgets.image.size.full_size'), null,
            function ($constraint) {
                $constraint->aspectRatio();
            })->save('widgets' . DIRECTORY_SEPARATOR . $filename);
        dd($image);
        exit;

        return $image;
    }

    /**
     * Create Icon From Original
     */
    public function icon($photo, $filename)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(\config('widgets.image.size.icon_size'), null,
            function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(Config::get('widgets.image.path.icon_path') . $filename);

        return $image;
    }

    /**
     * Delete File From Session folder, based on original filename
     */
    public function delete($originalFilename)
    {

        $full_size_dir = Config::get('images.full_size');
        $icon_size_dir = Config::get('images.icon_size');

        $sessionImage = Widget::where('original_name', 'like', $originalFilename)->first();


        if (empty($sessionImage)) {
            return Response::json([
                'error' => true,
                'code' => 400,
            ], 400);

        }

        $full_path1 = $full_size_dir . $sessionImage->filename;
        $full_path2 = $icon_size_dir . $sessionImage->filename;

        if (File::exists($full_path1)) {
            File::delete($full_path1);
        }

        if (File::exists($full_path2)) {
            File::delete($full_path2);
        }

        if (!empty($sessionImage)) {
            $sessionImage->delete();
        }

        return Response::json([
            'error' => false,
            'code' => 200,
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = [
            "~",
            "`",
            "!",
            "@",
            "#",
            "$",
            "%",
            "^",
            "&",
            "*",
            "(",
            ")",
            "_",
            "=",
            "+",
            "[",
            "{",
            "]",
            "}",
            "\\",
            "|",
            ";",
            ":",
            "\"",
            "'",
            "&#8216;",
            "&#8217;",
            "&#8220;",
            "&#8221;",
            "&#8211;",
            "&#8212;",
            "â€”",
            "â€“",
            ",",
            "<",
            ".",
            ">",
            "/",
            "?",
        ];
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}