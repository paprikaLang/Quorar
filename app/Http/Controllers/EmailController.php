<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
   public function verify($token){
      $user = User::where('confirmation_token',$token)->first();
      if (is_null($user)){
          flash('邮箱验证失败')->warning();
          return redirect('/');
      }
      $user->is_active = 1;
      $user->confirmation_token = str_random(40);
      $user->save();
      //需要登录才能跳转到主页面
      Auth::login($user);
      flash('邮箱验证成功')->success();
      return redirect('/home');

   }

}
