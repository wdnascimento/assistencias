<?php

namespace App\Events;

use App\Models\Sala;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ListarSalasAtivasEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $sala;

    public function __construct()
    {
        $this->sala = new Sala();
    }

    public function broadcastOn()
    {
        return new Channel('salas');
    }

    public function broadcastWith()
    {
        return $this->sala->where('status',1)->get();
    }

    public function broadcastAs()
    {
        return 'getSalasAtivas';
    }
}
