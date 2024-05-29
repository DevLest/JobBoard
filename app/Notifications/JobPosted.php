<?php

// app/Notifications/JobPosted.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class JobPosted extends Notification
{
    use Queueable;

    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $approveUrl = url('/jobs/approve/' . $this->job->id);
        $spamUrl = url('/jobs/spam/' . $this->job->id);

        return (new MailMessage)
            ->subject('New Job Posted')
            ->greeting('Hello!')
            ->line('A new job has been posted.')
            ->line('Title: ' . $this->job->title)
            ->line('Description: ' . $this->job->description)
            ->line(new HtmlString('<a href="' . $approveUrl . '" style="background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; margin-right: 10px;">Approve Job</a>'))
            ->line(new HtmlString('<a href="' . $spamUrl . '" style="background-color: #dc3545; color: white; padding: 10px 20px; text-decoration: none;">Mark as Spam</a>'))
            ->line('Regards,')
            ->line('JobBoard');
    }
}
