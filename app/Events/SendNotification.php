<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNotification implements ShouldBroadcast, ShouldQueue 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct(Task $task, String $message)
    {
        $this->task = $task;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('notifications');
    }

    public function broadcastAs()
    {
        return 'notifications-' . $this->task->user_id;
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }
}
