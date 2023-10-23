<?php

namespace App\Events;

use App\Models\Atendimento;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PainelSalaEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turma_id ;

    public function __construct($id)
    {
        $this->turma_id = $id;
    }

    public function broadcastOn()
    {
        return new Channel('painelsala.'.$this->turma_id);
    }

    public function broadcastWith()
    {
        $atendimento = new Atendimento();
        return [ 'data' =>  $atendimento->painelAtendimentoSala($this->turma_id)] ;
    }

    public function broadcastAs()
    {
        return 'getPainelSala';
    }
}
