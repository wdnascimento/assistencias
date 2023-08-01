<?php

namespace App\Events;

use App\Models\Aula;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AulaSalaEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sala_id ;

    public function __construct($id)
    {
        $this->sala_id = $id;
    }

    public function broadcastOn()
    {
        return new Channel('aulasala.'.$this->sala_id);
    }

    public function broadcastWith()
    {
        $aula = new Aula();
        return [ 'data' =>  $aula->aulasala($this->sala_id)] ;
    }

    public function broadcastAs()
    {
        return 'getAulaSala';
    }
}
