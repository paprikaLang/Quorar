<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionFollowController extends Controller
{
    public function __construct()
    {
        //中间件,只有登录才有后续关注问题的权限
        $this->middleware('auth');
    }

    public function follow($question){
//        dd($question);
        Auth::user()->follows($question);
        return back();
    }
}
