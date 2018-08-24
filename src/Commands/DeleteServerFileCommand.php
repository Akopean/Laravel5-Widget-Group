<?php

namespace Akopean\widgets\Commands;

use Akopean\widgets\Models\Widget;
use Illuminate\Console\Command;
use Akopean\widgets\FineUploaderServer;

class DeleteServerFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $widget, $fineUpload, $filesystem, $request;


    protected $description = 'Command description';

    /**
     * Create a new command instance.
     * @param Array $request
     * @param Widget $widget
     */
    public function __construct(Widget $widget, $request)
    {
        parent::__construct();

        $this->widget = $widget;
        $this->request = $request;

        $this->filesystem = config('widgets.storage.disk');

        $this->fineUpload = new FineUploaderServer($this->widget);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->widget->value;

        $id = null;
        $file_data = null;

        if (isset($data[$this->request['name']])) {
            foreach ($data[$this->request['name']] as $key => $value) {
                if ($value['qquuid'] === $this->request['uuid']) {
                    $file_data = array_splice($data[$this->request['name']], $key, 1)[0];
                    break;
                }

            }
        }

        $this->fineUpload->delete($file_data, $this->filesystem);

        $this->widget->value = $data;

        $this->widget->update();

    }
}
