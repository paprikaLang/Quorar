<?php
/**
 * Created by PhpStorm.
 * User: paprika
 * Date: 2018/11/8
 * Time: 1:52 PM
 */

namespace App\Channels;
use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable, Notification $notification) {
        $message = $notification->toSendcloud($notifiable);
    }
}