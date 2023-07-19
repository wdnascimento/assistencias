<?php

namespace App\Events;

use App\Models\Aula;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AulasAtivasEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return new Channel('aulas');
    }

    public function broadcastWith()
    {
        $data = Aula::ativas();
        return [ 'data' =>  $data] ;
    }

    public function broadcastAs()
    {
        return 'getAulasAtivas';
    }
}
