<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use App\UserBook;
use Illuminate\Http\Request;

class UserBookController extends Controller
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

    public function create(Request $request, $md5)
    {
        /** @var User $user */
        $user = \Auth::user();
        if (!$user->canAddBook()) {
            flash('非会员用户，最多可以拥有三本书籍，否则无法使用"阅读书籍"功能，你可以付费<a href="/users/plans">成为会员</a>，或者减少书籍到三本', 'danger');
            return redirect()->back();
        }
        /** @var Book $book */
        $book = Book::whereMd5($md5)->whereIsPublic(1)->firstOrFail();
        $userBook = UserBook::whereBookId($book->id)->whereUserId(\Auth::id())->first();
        if (!$userBook) {
            $userBook = new UserBook();
            $userBook->book_id = $book->id;
            $userBook->user_id = \Auth::id();
            $userBook->save();
        }

        flash('《' . $book->title . '》' . '添加成功', 'success');
        $redirectTo = $book->isWechat() ? '/books/wechat' : '/books/public';
        if ($request->all()) {
            $redirectTo .= '?' . http_build_query($request->all());
        }
        return redirect($redirectTo);
    }

    public function destroy($md5)
    {
        /** @var User $user */
        $user = \Auth::user();
        if (!$user->canRemoveBook()) {
            flash('非会员不可以删除最后三本书籍', 'danger');
            return redirect('/search');
        }
        $book = Book::whereMd5($md5)->firstOrFail();
        if ($user->hasBook($book)) {
            $userBook = UserBook::whereBookId($book->id)
                ->whereUserId($user->id)
                ->first();
            $userBook->delete();
            flash('《' . $book->title . '》' . '删除成功', 'success');
            return redirect('/search');
        }
        flash('你没有《' . $book->title . '》', 'danger');
        return redirect('/search');
    }
}
