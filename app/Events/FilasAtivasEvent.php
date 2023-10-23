<?php

namespace App\Events;

use App\Models\Atendimento;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FilasAtivasEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aula_id ;

    public function __construct($id)
    {
        $this->aula_id = $id;
    }

    public function broadcastOn()
    {
        return new Channel('filaaula.'.$this->aula_id);
    }

    public function broadcastWith()
    {
        $atendimento = new Atendimento();
        return [ 'data' =>  $atendimento->filaAula($this->aula_id)] ;
    }

    public function broadcastAs()
    {
        return 'getFilasAtivas';
    }
}
