<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomScout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:custom-import {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import by 10';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = $this->argument('model');
        $this->info('总共：' . $class::count() . '个');
        $class::chunk(50, function($models) {
            foreach ($models as $model) {
                try {
                    $model->searchable();
                } catch (\Exception $e) {
                    $this->info('error: ' . $e->getMessage() . PHP_EOL);
                }
            }
            $this->info('完成：' . count($models) . '个');
        });
    }
}
