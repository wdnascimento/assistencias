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

    public $turma_id ;

    public function __construct($id)
    {
        $this->turma_id = $id;
    }

    public function broadcastOn()
    {
        return new Channel('aulas.'.$this->turma_id);
    }

    public function broadcastWith()
    {
        $aula = new Aula();
        $data = $aula->ativas($this->turma_id);
        return [ 'data' =>  $data] ;
    }

    public function broadcastAs()
    {
        return 'getAulasAtivas';
    }
}
