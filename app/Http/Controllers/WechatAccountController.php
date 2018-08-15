<?php

namespace App\Http\Controllers;

use App\WechatAccount;
use Illuminate\Http\Request;

class WechatAccountController extends Controller
{

    const CAN_ADD_ACCOUNT_COUNT = 10;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        if (!\Auth::user()->isPaidVip()) {
            return response('只有年费会员可以添加公众号', 403);
        }
        $currentAddCount = WechatAccount::whereAddedByUserId(\Auth::user()->id)->count();
        if ($currentAddCount >= self::CAN_ADD_ACCOUNT_COUNT) {
            flash('添加失败，你已经添加了 ' . $currentAddCount . ' 个公众号，不可以再添加', 'danger');
            return redirect('/accounts/create');
        }
        $this->validate($request, [
            'nickname' => 'required',
            'post_content_url' => 'required',
        ]);

        WechatAccount::create([
            'nickname' => $request->get('nickname'),
            'post_content_url' => $request->get('post_content_url'),
            'added_by_user_id' => \Auth::user()->id,
        ]);
        flash('公众号"' . $request->get('nickname') . '"添加成功，我们会尽快添加，请您耐心等待', 'success');

        return redirect('/accounts/create');
    }
}
