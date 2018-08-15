<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPlanController extends Controller
{
    public function plans()
    {
        return view('users.plans');
    }
}
