<?php

namespace App\Notifications;

use App\Models\MembershipTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipApplicationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public MembershipTransaction $application)
    {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->application->loadMissing(['member', 'level']);

        return (new MailMessage)
            ->subject('Puihaha membership application received')
            ->greeting('Hello ' . $this->application->member->full_name . ',')
            ->line('We received your membership application.')
            ->line('Reference number: ' . $this->application->transaction_no)
            ->line('Membership level: ' . $this->application->level->name)
            ->line('Status: Pending verification')
            ->line('Please keep your reference number for your records.')
            ->salutation('Puihaha Membership Team');
    }
}
