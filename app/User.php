<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;
use Naux\Mail\SendCloudTemplate;
use Facades\App\Follow;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function owns(Model $model){
        return $this->id == $model->user_id;
    }
    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function follow() {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function follows($question) {
        return $this->follow()->toggle($question);
//        $new = Follow::create([
//            'question_id' => $question,
//            'user_id' => $this->id
//        ]);
//        return $new;
    }

    public function followed($question) {
        return !! $this->follow()->where('question_id', $question)->count();
    }

    public function followers(){
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }
    public function followeds(){
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }
    public function followThisUser($user) {
        return $this->followers()->toggle($user);
    }
    public function sendPasswordResetNotification($token)
    {
        $bind_data = ['url' => url('/password/reset',$token)];
        $template = new SendCloudTemplate('test_reset', $bind_data);
        Mail::raw($template, function ($message){
            $message->from('langtianyao1102@gmail.com', 'Quorar');
            $message->to($this->email);
        });

    }

}
