<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{
    public $answer; //cmd n -> cons -> 依赖注入的构造函数

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function users($id) {
        $user = Auth::guard('api')->user();
        if ($user->hasVotedFor($id)){
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }
    public function vote() {
        $answer = $this->answer->byId(request('answer')); //Auth::guard('api')->user() && Answer::find
        $voted = Auth::guard('api')->user()->voteFor(request('answer'));//request('ss') $request->get('ss')
        if (count($voted['attached']) > 0) {
            $answer->increment('votes_count');
//            $userToFollow->notify(new UserFollowNotification());
//            event(new NewFollowEvent($userToFollow));
            return response()->json(['voted'=> true]);
        }
        $answer->decrement('votes_count');
        return response()->json(['voted' => false]);
    }
}
