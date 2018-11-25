<?php

namespace App\Http\Controllers;

use Facades\App\Message;
use Illuminate\Http\Request;
use Auth;
use function PHPSTORM_META\map;

class InboxController extends Controller
{
    /**
     * InboxController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
//        $messages = Auth::user()->messages->groupBy('from_user_id');
//        foreach ($messages as $ms)
//            dd($ms->first);
        $messages = Message::where('to_user_id',Auth::user()->id)
            ->orWhere('from_user_id',Auth::user()->id)
            ->with(['fromUser','toUser'])->get();
        return view('inbox.index', ['messages' => $messages->groupBy('from_user_id')]);
    }
    public function showFromMsg($id) {

        $messages = Message::where('from_user_id', $id)->where('to_user_id', Auth::user()->id)->get();
        return $messages;
    }
    public function showToMsg($id){
        $messages = Message::where('to_user_id', $id )->where('from_user_id', Auth::user()->id)->get();
        return $messages;
    }
}
