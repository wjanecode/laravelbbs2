<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostReplied extends Notification
{
    use Queueable;
    protected $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        //

        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            //
            'reply_id'          => $this->reply->id,
            'reply_content'     => $this->reply->content,
            'reply_created_at'  => $this->reply->created_at,
            'reply_post_id'     => $this->reply->post_id,
            'reply_post_title'  => $this->reply->post->title,
            'reply_user_id'     => $this->reply->user_id,
            'reply_user_name'   => $this->reply->user->name,
            'reply_user_avatar' => $this->reply->user->avatar,
        ];
    }
}
