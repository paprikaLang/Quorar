<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/11/27
 * Time: 4:34 AM
 */

namespace App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
class MessageCollection extends Collection
{
    public function markAsRead(){
        $this->each(function ($message) {
            if ($message->to_user_id === Auth::user()->id){
                $message->markAsRead();
            }
        });
    }

}