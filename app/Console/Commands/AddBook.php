<?php

namespace App\Console\Commands;

use App\Book;
use App\UserBook;
use Illuminate\Console\Command;

class AddBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:add_to_admin {bookId}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a book to jinma.';

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
        if (UserBook::whereBookId($bookId)->whereUserId(1)->exists()) {
            return;
        }
        if (!$book = Book::find($bookId)) {
            $this->info('book 不存在');
        }
        $userBook = new UserBook();
        $userBook->user_id = 1;
        $userBook->book_id = $bookId;
        $userBook->save();
    }
}
