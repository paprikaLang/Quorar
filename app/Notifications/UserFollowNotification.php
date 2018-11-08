<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;
use Mail;

class UserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }
    public function toSendcloud($notifiable){
        $bind_data = ['url' => 'https://quora.test/','name' => Auth::guard('api')->user()->name];
        $template = new SendCloudTemplate('test_follow', $bind_data);
        Mail::raw($template, function ($message) use ($notifiable){
            $message->from('langtianyao1102@gmail.com', 'Quorar');
            $message->to($notifiable->email);
        });

    }

    public function toDatabase($notifiable){
        return [
            'name' => Auth::guard('api')->user()->name,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
