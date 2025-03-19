<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostLikedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $post;
    public $likeUser;
    public function __construct($post, $likeUser)
    {
        $this->post = $post;
        $this->likeUser = $likeUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line("Hello". $this->post->user->first_name .".")
        ->line("Your post with the title: ". $this->post->title ." has recieved a like")
        ->action("You can view the post here: ", route("post.show", ["id" => $this->post->id]))
        ->action("You can view the user here: ", route("user.show", ["id" => $this->likeUser->id]))
        ->line("Thank you for creating a post!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
