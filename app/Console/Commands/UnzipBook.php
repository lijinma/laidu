<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnzipBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:unzip {bookId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a unzip book job.';

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
        $bookId = $this->argument('bookId');
        $book = \App\Book::find($bookId);
        dispatch(new \App\Jobs\UnzipBookAndSetup($book));
    }
}
