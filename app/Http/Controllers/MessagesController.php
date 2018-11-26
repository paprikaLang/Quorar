<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    protected $message;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    public function send() {
        $msg =  $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => Auth::guard('api')->user()->id,
            'body' => request('body'),
            'dialog_id'=>(Auth::guard('api')->user()->id+request('user')).(0).(Auth::guard('api')->user()->id * request('user'))
        ]);
        if ($msg) {
            return response()->json(['status'=> true]);
        }
        return response()->json(['status'=> false]);
    }
}
