<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        protected Task $task,
        protected string $childName
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'child_name' => $this->childName,
            'status' => $this->task->status,
            'message' => "{$this->childName} a marqué la tâche \"{$this->task->title}\" comme {$this->getStatusLabel()}.",
        ];
    }

    private function getStatusLabel(): string
    {
        return match($this->task->status) {
            'todo' => 'à faire',
            'in_progress' => 'en cours',
            'done' => 'terminée',
            default => $this->task->status,
        };
    }
}
