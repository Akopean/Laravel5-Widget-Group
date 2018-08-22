<?php

namespace Akopean\widgets\Commands;

use Akopean\widgets\Models\Widget;
use Illuminate\Console\Command;
use Akopean\widgets\FineUploaderServer;

class UploadServerFile extends Command
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

    protected $widget, $fineUpload, $request, $filesystem, $slug;


    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param Widget $widget
     * @param Array $request
     */
    public function __construct(Widget $widget, $request)
    {
        parent::__construct();

        $this->widget = $widget;
        $this->request = $request;

        $this->filesystem = config('widgets.storage.disk');
        $this->slug = config('widgets.storage.slug');

        $this->fineUpload = new FineUploaderServer($this->widget);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            $this->fineUpload->upload($this->request, $this->filesystem, $this->slug);
    }
}
