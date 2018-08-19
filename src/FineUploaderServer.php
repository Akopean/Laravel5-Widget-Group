<?php

namespace Akopean\widgets;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Config;
use Intervention\Image\ImageManager;
use Akopean\widgets\Models\Widget;
use \Illuminate\Http\File;


class FineUploaderServer
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
     */
    public function upload($form_data)
    {

        $this->field_options = $this->widget->getFieldOptions($form_data['name']);
        $this->form_data = $form_data;

        $this->uploadFile();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    private function uploadFile()
    {
       $files = null;
        $qqfile = $this->form_data['qqfile'];

        $this->validateFileType();

        $file_size = $this->form_data['qqtotalfilesize'];

        $original_name = $this->sanitize(explode('.', $qqfile->getClientOriginalName())[0]);
        $extension = $qqfile->getClientOriginalExtension();
        $full_name = $this->createUniqueFilename($original_name, $extension);
        $file_path = $this->generatePath() . $full_name;

        $file = Storage::disk($this->filesystem)->put($this->slug, $qqfile);
        //original file path
        $original_path = Storage::disk($this->filesystem)->move($file, $file_path) ? $file_path : $file;
        $files['original'] = [
            'path' => $original_path,
            'url' => Storage::disk($this->filesystem)->url($original_path),
            ];

        if ($this->field_options['type'] === 'image') {
            $icon = null;
            //start cropping
            if ($qqfile->getClientOriginalExtension() !== 'gif' || $qqfile->getClientOriginalExtension() !== 'svg') {

                $icon = $this->createIcon($qqfile,$original_name . '_icon.' . $extension);
                $files['icon'] = [
                    'path' => $icon,
                    'url' => Storage::disk($this->filesystem)->url($icon),
                ];
            }
        }

        $value = $this->widget->value;

        $value[$this->form_data['name']][] = [
            'qqfilename' => $full_name,
            'qquuid' => $this->form_data['qquuid'],
            'qqtotalfilessize' => $file_size,
            'paths' => $files,
        ];

        $this->widget->value = $value;

        $this->widget->update();
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

    /**
     * @param $filename
     * @param $extension
     * @return string
     */
    public function createUniqueFilename($filename, $extension)
    {
        $full_path = $this->generatePath() . $filename . '.' . $extension;

        if (Storage::disk($this->filesystem)->exists($full_path)) {
            // Generate token for image
            $token = substr(sha1(mt_rand()), 0, 5);

            return $filename . '-' . $token . '.' . $extension;
        }

        return $filename . '.' . $extension;
    }

    /**
     * Cropping image
     * @param $photo
     * @param string $filename
     * @param array $size = ['width', 'height']
     * @return \Intervention\Image\Image
     */
    public function crop($photo, $filename, $size)
    {
        $manager = new ImageManager();


        $image = $manager->make($photo)->resize($size['width'], $size['height'],
            function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images' . DIRECTORY_SEPARATOR . $filename));

        return $image;
    }

    /**
     * Create Icon From Original
     * @param $photo
     * @param path
     * @return string
     */
    public function createIcon($photo, $path)
    {
        $image = $this->crop($photo, $path, \config('widgets.file.image.size.icon_size'));

        $saved_image_uri = $image->dirname . DIRECTORY_SEPARATOR . $image->basename;

        $uploaded_icon_image = Storage::disk($this->filesystem)->putFileAs(
            $this->generatePath() . Config::get('widgets.file.image.path.crop'),
            new File($saved_image_uri),
            $path);

        $image->destroy();
        unlink($saved_image_uri);

        return $uploaded_icon_image;
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