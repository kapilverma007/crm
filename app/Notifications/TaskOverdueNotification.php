<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class TaskOverdueNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $customerName = $this->task->customer?->full_name ?? 'Unknown';
        $dueDate = $this->task->due_date->format('d M Y h:i A');

        $message = FilamentNotification::make()
            ->danger()
            ->icon('heroicon-o-exclamation-triangle')
            ->title('Missed Task!')
            ->body("Your task for **{$customerName}** was due on {$dueDate} and is still incomplete. Please complete it as soon as possible.")
            ->getDatabaseMessage();

        $message['task_id'] = $this->task->id;

        return $message;
    }
}
