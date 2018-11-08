<?php

namespace App\Listeners;

use App\Events\NewFollowEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Naux\Mail\SendCloudTemplate;
use Mail;

class NewFollowEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewFollowEvent  $event
     * @return void
     */
    public function handle(NewFollowEvent $event)
    {
        $bind_data = ['url' => 'https://quora.test/','name' => Auth::guard('api')->user()->name];
        $template = new SendCloudTemplate('test_follow', $bind_data);
        Mail::raw($template, function ($message) use ($event){
            $message->from('langtianyao1102@gmail.com', 'Quorar');
            $message->to($event->user->email);
        });
    }
}
