<?php

namespace FaithGen\SDK\Notifications\Ministry;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPassword extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Ministry
     */
    private $ministry;

    /**
     * Create a new notification instance.
     *
     * @param Ministry $ministry
     */
    public function __construct(Ministry $ministry)
    {
        $this->ministry = $ministry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello ' . $this->ministry->name)
            ->line('You have requested for a password change, Please click the link below to update it!')
            ->action('Reset Password', url('/'))
            ->from('no-reply@faithgen.com', 'Faith Gen')
            ->subject('Forgot password!')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
