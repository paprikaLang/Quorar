<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Facades\App\Topic;
use Facades\App\Follow;
use Illuminate\Support\Facades\Auth;
use Facades\App\Question;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/topics', function (Request $request) {

    $topics = Topic::select(['id','name'])->
        where('name','like','%'.$request->query('q').'%')
        ->get();
    return $topics;
});

Route::middleware('auth:api')->post('/question/follower', function (Request $request) {
//    return response()->json(['followed' => false]);
//    return response()->json(['question' => request('question')]);
//    $followed = Follow::where('question_id', $request->get('question'))
//        ->where('user_id',$request->get('user'))
//        ->count();
    $user = Auth::guard('api')->user();
    if ($user->followed($request->get('question'))) {
        return response()->json(['followed'=> true]);
    }
    return response()->json(['followed'=>false]);
});

Route::middleware('auth:api')->post('/question/follow', function (Request $request) {
//    $followed = Follow::where('question_id', $request->get('question'))
//        ->where('user_id',$request->get('user'))
//        ->first();
//    if ($followed !== null) {
//        $followed->delete();
//        return response()->json(['followed'=> false]);
//    }
//    Follow::create([
//        'question_id' => $request->get('question'),
//        'user_id' => $request->get('user'),
//    ]);
    $user = Auth::guard('api')->user();
    $question = Question::find($request->get('question'));
    $followed = $user->follows($question->id);
    if (count($followed['detached']) > 0) {
        $question->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
    $question->increment('followers_count');
    return response()->json(['followed'=>true]);
});
Route::get('/user/followers/{id}','FollowersController@index');
Route::post('/user/follow','FollowersController@follow');

