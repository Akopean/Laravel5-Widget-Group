<?php

namespace Akopean\widgets\Repository;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Akopean\widgets\Models\Widget;


class FileRepository
{
    private $field_options;
    private $widget;
    private $form_data;

    /** @var string */
    protected $filesystem;

    protected $slug;

    /**
     * FileRepository constructor.
     * @param Widget $widget
     */
    public function __construct(Widget $widget)
    {
        $this->filesystem = config('widgets.storage.disk', 'public');
        $this->slug = config('widgets.storage.slug', 'widgets');
        $this->widget = $widget;
    }

    /**
     * @param array $form_data
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload($form_data)
    {
        $this->field_options = $this->widget->getFieldOptions($form_data['name']);
        $this->form_data = $form_data;

        switch ($this->field_options['type']) {
            case 'image':
                $this->uploadImage();
                break;
            default:
                $this->uploadFile();
                break;
        }
        /*
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
*/
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function uploadFile()
    {
        $this->validateFileType();

        $file = $this->form_data['qqfile'];
        $name = $this->form_data['name'];
        $uuid = $this->form_data['qquuid'];
        $file_size = $this->form_data['qqtotalfilesize'];

        $file_name = Storage::disk($this->filesystem)->put($this->slug, $file);
        $value = json_decode($this->widget->value);

        $value->$name[] = [
            'qqfilename' => $file_name,
            'qquuid' => $uuid,
            'qqtotalfilessize' => $file_size,
        ];

        $this->widget->value = json_encode($value);

        $this->widget->update();

    }

    private function uploadImage()
    {
        $this->validateFileType();
    }

    /**
     * Validate File Field
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function validateFileType()
    {
        $rules = null;

        if (isset($this->field_options['rules'])) {
            $rules = $this->field_options['rules'];
        } else {
            $rules = \config('widgets.file.rules');
        }

        return $this->validate($this->form_data,
            [
                $this->form_data['name'] . '.*' =>
                    'required' .
                    (isset($rules['mimes']) ? '|mimes:' . $rules['mimes'] : '') .
                    (isset($rules['size']['min']) ? '|min:' . $rules['size']['min'] : '') .
                    (isset($rules['size']['max']) ? '|max:' . $rules['size']['max'] : ''),
            ],
            \config('widgets.file.messages'));
    }

    /**
     * @param $data
     * @param $rules
     * @param $messages
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function validate($data, $rules, $messages)
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400,
            ], 400);
        }

        return true;
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

        return $image;
    }

    /**
     * Create Icon From Original
     * @param $photo
     * @param $filename
     * @return \Intervention\Image\Image
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
     *  * Delete File From Session folder, based on original filename
     * @param $originalFilename
     * @return \Illuminate\Http\JsonResponse
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


    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->slug . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
    }
}