<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Admin;
use App\User;
use App\VipLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(Admin::class);
    }

    public function index(Request $request)
    {
        $q = $request->get('query');
        if ($q) {
            $users = User::with('vipLogs')->whereEmail($q)->orderBy('id', 'desc')->paginate(10);
        } else {
            $users = User::with('vipLogs')->orderBy('id', 'desc')->paginate(10);
        }

        return view('users.admin', compact('users', 'q'));
    }

    public function vipAdd(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'months' => 'required|integer',
            'email' => 'required|email',
            'remark' => 'required'
        ]);
        /** @var User $user */
        $user = User::findOrFail($request->get('user_id'));
        $months = $request->get('months');
        $user->addVipDuration($months, $request->get('remark'));

        flash('成功添加为 ' . $request->get('email') . ' 添加 ' . $months . ' 个月', 'success');

        return redirect('/admin?query=' . $request->get('email'));
    }
}
