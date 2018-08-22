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
        $this->widget = $widget;
    }

    /**
     * @param $form_data
     * @param $filesystem
     * @param $slug
     */
    public function upload($form_data, $filesystem, $slug)
    {

        $this->field_options = $this->widget->getFieldOptions($form_data['name']);
        $this->form_data = $form_data;
        $this->filesystem = $filesystem;
        $this->slug = $slug;

        $qqfile = $this->form_data['qqfile'];

        $this->validateFileType();

        $this->uploadFile($qqfile);
    }

    /**
     * @param $qqfile
     * @return \Illuminate\Http\JsonResponse
     */
    private function uploadFile($qqfile)
    {
        $files = null;

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

                $icon = $this->createIcon($qqfile, $full_name);
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
     */
    private function validateFileType()
    {
        $rules = null;

        if (isset($this->field_options['rules'])) {
            $rules = $this->field_options['rules'];
        } else {
            $rules = \config('widgets.file.rules');
        }

        $this->validate($this->form_data,
            [
                'qqfile' =>
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
     * @return bool
     * @throws \Exception
     */
    private function validate($data, $rules, $messages)
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new \Exception($validator->messages()->first());
        }
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
     * Create Icon From Original
     * @param $photo
     * @param path
     * @return string
     */
    protected function createIcon($photo, $name)
    {
        $params = config('widgets.file.image.size.icon');

        $manager = new ImageManager();

        $image = $manager->make($photo)->resize($params['width'], $params['height']);

        $path = $this->generatePath() . Config::get('widgets.file.image.path.icon') . DIRECTORY_SEPARATOR . $name;

        Storage::disk($this->filesystem)->put(
            $path,
            (string)$image->encode()
        );

        return $path;
    }

    /**
     * Delete File From Session folder, based on original filename
     * @param $file_data
     * @param $filesystem
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete($file_data, $filesystem)
    {
        if (Storage::disk($filesystem)->has(($file_data['paths']['original']['path']))) {
            if (!Storage::disk($filesystem)->delete($file_data['paths']['original']['path'])) {
                throw new \Exception('Error while deleting original file');
            }
        }

        if (isset($file_data['paths']['icon']) && Storage::disk($filesystem)->has(($file_data['paths']['icon']['path']))
        ) {
            if (!Storage::disk($filesystem)->delete($file_data['paths']['icon']['path'])) {
                throw new \Exception('Error while deleting icon file');
            }
        }
    }

    public function sanitize($string, $force_lowercase = true, $anal = false)
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