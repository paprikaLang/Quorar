<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $bind_data = ['url' => url('/password/reset',$token)];
        $template = new SendCloudTemplate('test_reset', $bind_data);

        Mail::raw($template, function ($message){

            $message->from('langtianyao1102@gmail.com', 'ZHIHU');

            $message->to($this->email);
        });

    }

}
