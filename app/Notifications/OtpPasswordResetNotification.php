<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * OTP Password Reset Notification
 * 
 * This notification sends an OTP (One-Time Password) to the user's email
 * for password reset verification. It demonstrates how to create custom
 * email notifications in Laravel.
 * 
 * @package App\Notifications
 */
class OtpPasswordResetNotification extends Notification
{
    /**
     * The OTP code to be sent to the user
     * 
     * @var string
     */
    private $otp;

    /**
     * Create a new notification instance
     * 
     * @param string $otp The one-time password for password reset
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels
     * 
     * This method defines which channels the notification will be sent through.
     * Available channels: 'mail', 'database', 'broadcast', 'nexmo', 'slack'
     * 
     * @param mixed $notifiable The entity receiving the notification (usually User model)
     * @return array Array of notification channels
     */
    public function via($notifiable)
    { 
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification
     * 
     * This method builds the email message that will be sent to the user.
     * Laravel's MailMessage provides a fluent interface for building emails.
     * 
     * @param mixed $notifiable The entity receiving the notification
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Password Reset OTP')
            ->line('Your OTP for password reset is: ' . $this->otp)
            ->line('Please use this OTP to reset your password.')
            ->action('Reset Password', url('/password/reset'))
            ->line('If you did not request this, please ignore this email.');
    }
}
