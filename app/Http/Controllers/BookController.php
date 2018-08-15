<?php

namespace App\Http\Controllers;

use App\Book;
use App\Jobs\UnzipBookAndSetup;
use App\Page;
use App\User;
use App\UserBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        /** @var User $user */
        $user = \Auth::user();
        $pages = [];
        $userBookIds = $user->userBooks->map(function ($userBook) {
            return $userBook->book_id;
        });
        $userBookCount = count($userBookIds);
        $userBooks = $user->userBooks()
            ->with('book')
            ->orderBy('id', 'desc')
            ->get();
        $books = $userBooks->map(function ($userBook) {
            return $userBook->book;
        });
        $q = $request->get('query');
        if ($q) {
            if (!$user->canSearch()) {
                flash('非会员用户，最多可以拥有三本书籍，否则无法使用"搜索"功能，你可以付费<a href="/users/plans">成为会员</a>，或者减少书籍到三本', 'danger');
                return redirect('/search');
            }
            $bookId = $userBookIds;
            if ($request->get('book')) {
                $book = Book::whereMd5($request->get('book'))->firstOrFail();
                $bookId = [$book->id];
            }
            $query = [
                'query' => $q,
                'filter' => [
                    'terms' => [
                        "book_id" => $bookId
                    ]
                ]
            ];
            $pages = Page::search($query)->paginate(10)->appends($request->all());
        }

        return view('books.search', compact('books', 'pages', 'q', 'userBookCount'));
    }

    public function index()
    {
        $user = \Auth::user();
        $userBooks = $user->userBooks()
            ->with('book')
            ->orderBy('id', 'desc')
            ->get();
        $books = $userBooks->map(function ($userBook) {
            return $userBook->book;
        });

        return view('books.index', compact('books'));
    }

    public function show($md5, $pageName)
    {
        /** @var User $user */
        $user = \Auth::user();
        if (!$user->canViewBook()) {
            flash('非会员用户，最多可以拥有三本书籍，否则无法使用"阅读书籍"功能，你可以付费<a href="/users/plans">成为会员</a>，或者减少书籍到三本', 'danger');
            return redirect('/search');
        }
        $book = Book::with([
            'pages' => function ($query) {
                $query->limit(600);
            }
        ])->whereMd5($md5)->firstOrFail();
        if (!\Auth::user()->hasBook($book)) {
            throw new ModelNotFoundException();
        }
        if ($pageName == 'index') {
            $currentPage = Page::whereBookId($book->id)
                ->orderBy('order', 'desc')
                ->orderBy('id')
                ->firstOrFail();
        } else {
            $currentPage = Page::whereBookId($book->id)
                ->whereUrl($pageName)
                ->firstOrFail();
        }
        if ($currentPage->order != 0) {
            $nextPage = Page::whereBookId($book->id)
                ->where('order', '<', $currentPage->order)
                ->orderBy('order', 'desc')
                ->orderBy('id')
                ->first();
            $previousPage = Page::whereBookId($book->id)
                ->where('order', '>', $currentPage->order)
                ->orderBy('order', 'asc')
                ->orderBy('id')
                ->first();
        } else {
            $nextPage = Page::whereBookId($book->id)
                ->whereId($currentPage->id + 1)
                ->first();
            $previousPage = Page::whereBookId($book->id)
                ->whereId($currentPage->id - 1)
                ->first();
        }

        return view('books.show', compact('book', 'currentPage', 'previousPage', 'nextPage'));
    }

    public function public (Request $request)
    {
        $user = \Auth::user();
        $userBookIds = $user->userBooks()->pluck('book_id')->toArray();

        $query = Book::whereIsPublic(1);
        $query->whereIn('type', [Book::TYPE_EPUB, Book::TYPE_MOBI]);
        if ($request->has('chosen')) {
            $query->whereIn('id', $userBookIds);
        }

        $books = $query->orderBy('id', 'desc')->paginate(18);
        $books->appends($request->all());

        return view('books.public', compact('userBookIds', 'books'));
    }

    public function wechat(Request $request)
    {
        $user = \Auth::user();
        $userBookIds = $user->userBooks()->pluck('book_id')->toArray();

        $query = Book::whereIsPublic(1);
        $query->where('type', Book::TYPE_WECHAT);
        if ($request->has('chosen')) {
            $query->whereIn('id', $userBookIds);
        }
        if ($request->has('recent')) {
            $query->orderBy('id', 'desc');
        } else {
            $query->orderBy('selected_count', 'desc');
        }

        $books = $query->paginate(18);
        $books->appends($request->all());

        return view('books.wechat', compact('userBookIds', 'books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'book' => 'required|max:10240'
        ]);
        /** @var User $user */
        $user = \Auth::user();
        $extension = $request->file('book')->getClientOriginalExtension();
        if (!in_array($extension, ['epub', 'mobi'])) {
            throw new \InvalidArgumentException('必须是 epub 或者 mobi 格式');
        }
        $path = $request->file('book')->store($extension);
        $realPath = storage_path('app/') . $path;
        $md5 = md5_file($realPath);
        $newRealPath = storage_path() . '/app/epubs/' . $md5 . '.' . $extension;
        if (!$book = Book::whereMd5($md5)->first()) {
            rename($realPath, $newRealPath);
            $book = new Book();
            $book->md5 = $md5;
            $book->type = Book::TYPE_TEXTS_REVERSE[$extension];
            $book->file = $newRealPath;
            $book->title = $request->get('title');
            $book->save();
            dispatch(new \App\Jobs\UnzipBookAndSetup($book));
        }
        if (!$user->canAddBook()) {
            flash('非会员用户，最多可以拥有三本书籍，否则无法使用"阅读书籍"功能，你可以付费<a href="/users/plans">成为会员</a>，或者减少书籍到三本', 'danger');
        } else {
            $this->createUserBook($book);
            flash('《' . $book->title . '》' . '上传成功，正在紧急处理中，30秒后请刷新页面', 'success');
        }

        return [];
    }

    protected function createUserBook(Book $book)
    {
        $userBook = UserBook::whereBookId($book->id)->whereUserId(\Auth::id())->first();
        if ($userBook) {
            return $userBook;
        }
        $userBook = new UserBook();
        $userBook->user_id = \Auth::id();
        $userBook->book_id = $book->id;
        $userBook->save();

        return $userBook;
    }
}
