<?php

namespace App\Http\Controllers;

use App\Events\NewFollowEvent;
use App\Notifications\UserFollowNotification;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id) {
        $followed = $this->user->byId($id);
        $followers = $followed->followeds()->pluck('follower_id')->toArray();
        if (in_array(Auth::guard('api')->user()->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }
    public function follow() {
        $userToFollow = $this->user->byId(request('user'));
        $followed = Auth::guard('api')->user()->followThisUser($userToFollow);
        if (count($followed['attached']) > 0) {
            $userToFollow->increment('followers_count');
            $userToFollow->notify(new UserFollowNotification());
//            event(new NewFollowEvent($userToFollow));
            return response()->json(['followed'=> true]);
        }
        $userToFollow->decrement('followers_count');
        return response()->json(['followed' => false]);

    }
    public function sendMessage($id) {
        $user = $this->user->byId($id);
        $name = $user->name;
        return response()->json(['name'=> $name]);
    }
}
