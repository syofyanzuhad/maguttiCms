<?php

namespace App\maguttiCms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPasswordNotification extends Notification implements ShouldQueue
{
	public string $token;
    use Queueable;

	/**
	 * Create a notification instance.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable): array
    {
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable): MailMessage
    {
		return (new MailMessage)
			->subject(trans('passwords.mail_reset_subject').' - '.config('app.name'))
			->greeting(trans('website.mail_message.greeting'))
			->line(trans('passwords.mail_reset_body'))
			->action(trans('passwords.mail_reset_button'), url_locale('password/reset').'/'.$this->token)
			->line(trans('passwords.mail_reset_footer'));
	}
}
