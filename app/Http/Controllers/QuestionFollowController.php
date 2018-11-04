<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionFollowController extends Controller
{
    public function follow($question){
//        dd($question);
        Auth::user()->follows($question);
        return back();
    }
}
