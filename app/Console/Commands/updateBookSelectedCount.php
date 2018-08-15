<?php

namespace App\Console\Commands;

use App\Book;
use App\UserBook;
use Illuminate\Console\Command;

class updateBookSelectedCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:update-selected-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update books selected count.';

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
        Book::chunk(100, function ($books) {
            foreach ($books as $book) {
                $book->selected_count = UserBook::whereBookId($book->id)->count();
                $book->save();
            }
            $this->info('完成100条');
        });
    }
}
