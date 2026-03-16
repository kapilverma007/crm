<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class TaskDueSoonNotification extends Notification
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
        $dueTime = $this->task->due_date->format('h:i A');

        $message = FilamentNotification::make()
            ->warning()
            ->icon('heroicon-o-bell-alert')
            ->title('Task Due in 30 Minutes!')
            ->body("Your task for **{$customerName}** is due at {$dueTime}. Please get ready!")
            ->getDatabaseMessage();

        $message['task_id'] = $this->task->id;

        return $message;
    }
}
