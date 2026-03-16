<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskDueSoonNotification;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';

    protected $description = 'Send notifications for tasks due soon (30 min) and overdue/missed tasks';

    public function handle(): int
    {
        $now = Carbon::now();
        $in30Min = $now->copy()->addMinutes(30);

        // 1. Tasks due within next 30 minutes - early reminder
        $dueSoon = Task::with(['customer', 'employee'])
            ->where('is_completed', false)
            ->whereNotNull('user_id')
            ->whereNotNull('due_date')
            ->where('due_date', '>', $now)
            ->where('due_date', '<=', $in30Min)
            ->get();

        $soonCount = 0;
        foreach ($dueSoon as $task) {
            if ($task->employee && !$this->alreadyNotified($task, TaskDueSoonNotification::class)) {
                $task->employee->notify(new TaskDueSoonNotification($task));
                $soonCount++;
            }
        }

        // 2. Overdue/missed tasks - past due date and still incomplete
        $overdue = Task::with(['customer', 'employee'])
            ->where('is_completed', false)
            ->whereNotNull('user_id')
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now)
            ->get();

        $overdueCount = 0;
        foreach ($overdue as $task) {
            if ($task->employee && !$this->alreadyNotified($task, TaskOverdueNotification::class)) {
                $task->employee->notify(new TaskOverdueNotification($task));
                $overdueCount++;
            }
        }

        $this->info("Sent {$soonCount} due-soon reminders and {$overdueCount} overdue alerts.");

        return self::SUCCESS;
    }

    /**
     * Check if a notification was already sent for this task.
     */
    private function alreadyNotified(Task $task, string $notificationType): bool
    {
        return DB::table('notifications')
            ->where('notifiable_id', $task->employee->id)
            ->where('notifiable_type', get_class($task->employee))
            ->where('type', $notificationType)
            ->where('data->task_id', $task->id)
            ->exists();
    }
}
