<?php
/*
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Message;


class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $user;
    public $message;

    public function __construct(User $users, Message $messages)
    {
        $this->user = $users;
        $this->message = $messages;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastWith() {
        return [
            'message' => $this->message,
            'user' => $this->user,
        ];
    }
}
