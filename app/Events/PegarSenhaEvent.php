<?php
/*
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class PegarSenhaEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sala;

    public function __construct($sala)
    {
        $this->sala = $sala;

    }

    public function broadcastOn()
    {
        return new Channel('assistencia');
    }

    public function broadcastAs()
    {
        return 'PegarSenha';
    }

    public function broadcastWith() {
        $data = DB::table('aulas','au')
                ->join('professors as pr', 'pr.id' , 'au.professor_id')
                ->join('disciplinas as di', 'di.id' , 'au.disciplina_id')
                ->leftJoin('atendimentos as at', function ($join) {
                        $join->on('at.aula_id', '=', 'au.id')
                        ->whereIn('at.status',[0,1]);
                        })
                ->leftJoin('users as us', 'us.id' , 'at.user_id')
                ->select('au.id as aula_id', 'at.id as atendimento_id', 'au.status as status_aula', 'au.sala_id as sala_id'
                        , 'at.status as status', DB::raw("SUBSTRING_INDEX(pr.name, ' ', 1) as professor")
                        ,  DB::raw("SUBSTRING_INDEX(us.name, ' ', 1) as nome"), 'us.name as nome_completo'
                        ,  'us.numero as numero', 'us.cabine as cabine', 'di.titulo as titulo_disciplina')
                ->where('au.sala_id',$this->sala)
                ->where('au.status',1)
                ->orderBy('at.ordem')
                ->orderBy('at.status', 'desc')
                ->get();

        return $data;

    }
}
