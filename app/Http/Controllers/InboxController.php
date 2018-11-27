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
            ->with(['fromUser' => function($query){
                return $query->select(['id','name','avatar']);
            },'toUser'=> function($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();  // $query 返回只想暴露的user信息
//        return $messages->unique('dialog_id')->groupBy('from_user_id');
        return view('inbox.index', ['messages' => $messages->unique('dialog_id')->groupBy('from_user_id')]);
    }
    public function show($dialogId) {

//        $messages = Message::where('from_user_id', $id)->where('to_user_id', Auth::user()->id)->get();
        $messages = Message::where('dialog_id',$dialogId)->latest()->get(); //latest reverse 都有倒序的作用
        $messages->markAsRead();
        return view('inbox.show',compact('messages','dialogId'));
    }
    public function store($dialogId){
        $message = Message::where('dialog_id', $dialogId)->first();
        $toUserId = $message->from_user_id === Auth::user()->id ? $message->to_user_id : $message->from_user_id;
        Message::create([
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        return back();
    }

}
