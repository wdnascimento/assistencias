<?php

namespace App\Models;

use App\Events\AulaSalaEvent;
use App\Events\AulasAtivasEvent;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sala;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\Atendimento;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class Aula extends Model
{

    protected $fillable = ['disciplina_id', 'professor_id', 'sala_id', 'sala' ,'disciplina', 'professor' , 'date', 'inicio','fim', 'status', 'created_by'];


    public function sala(){
        return $this->belongsTo(Sala::class);
    }

    public function ativas(){
        return Aula::select( 'aulas.id','salas.id as sala_id','professors.id as professor_id'
                                    ,'salas.titulo as sala'
                                    ,DB::raw("(SUBSTRING_INDEX(professors.name, ' ', 1)) as professor")
                                    ,'disciplinas.titulo as disciplina' )
                        ->join('salas','salas.id','aulas.sala_id')
                        ->join('professors','professors.id','aulas.professor_id')
                        ->join('disciplinas','disciplinas.id','aulas.disciplina_id')
                        ->where('aulas.status',1)
                        ->with('emAtendimento')
                        ->orderBy('salas.titulo')
                        ->get();
    }

    public function aulasala($id){
        return Aula::select( 'aulas.id','salas.id as sala_id','professors.id as professor_id'
                                    ,'salas.titulo as sala'
                                    ,DB::raw("(SUBSTRING_INDEX(professors.name, ' ', 1)) as professor")
                                    ,'disciplinas.titulo as disciplina' )
                        ->join('salas','salas.id','aulas.sala_id')
                        ->join('professors','professors.id','aulas.professor_id')
                        ->join('disciplinas','disciplinas.id','aulas.disciplina_id')
                        ->where('aulas.status',1)
                        ->where('aulas.sala_id',$id)
                        ->with('emAtendimento')
                        ->orderBy('salas.titulo')
                        ->get();
   }

    public function disciplina(){
        return $this->belongsTo(Disciplina::class);
    }

    public function professor(){
        return $this->belongsTo(Professor::class);
    }

    public function atendimento(){
        return $this->hasMany(Atendimento::class)->whereIn('status',[0,1])->orderBy('status','desc')->orderBy('ordem');
    }

    public function atendimentoUser(){
        return $this->hasManyThrough(User::class,Atendimento::class,'aula_id','id','id','id','id');
    }

    public function atendimentos(){
        return $this->hasMany(Atendimento::class)->where('status',0);
    }

    public function emAtendimento(){
        return $this->hasMany(Atendimento::class)
                    ->select( 'atendimentos.aula_id'
                                , DB::raw("(SELECT CONCAT(u.numero, ' - ',SUBSTRING_INDEX(u.name, ' ', 1)) FROM users u WHERE u.id = atendimentos.user_id) as nome"))
                    ->where('atendimentos.status',1)
                    ->limit(1);
    }

    public function fila(){
        return $this->hasMany(Atendimento::class)
                    ->select(   'atendimentos.id','atendimentos.user_id','atendimentos.aula_id'
                                ,'atendimentos.ordem','atendimentos.status'
                                , DB::raw("(SELECT CONCAT(u.numero, ' - ',SUBSTRING_INDEX(u.name, ' ', 1)) FROM users u WHERE u.id = atendimentos.user_id) as nome"))
                    ->whereIn('atendimentos.status',[0,1])
                    ->orderBy('atendimentos.status','desc')
                    ->orderBy('atendimentos.ordem');
    }

    public function hasAtendimentos(){

        return $this->hasMany(Atendimento::class)->whereIn('status',[0,1])->where('user_id',Auth::user()->id);

    }

    public function cadastrarAulaProfessor($data){
        $data['created_by']= Auth::user()->email;
        // data [disciplina_id, sala_id, professor_id]
       try {
            DB::beginTransaction();
            // PROCURA AULAS ATIVA NESTA SALA
            $sala = $this->select('id')->where('sala_id',$data['sala_id'])->where('status',1)->get()->pluck('id')->toArray();
            $professor = $this->select('id')->where('professor_id',$data['professor_id'])->where('status',1)->get()->pluck('id')->toArray();
            if($sala != null || $professor != null){
                if($this->whereIn('id',array_merge($sala,$professor))->update(array('status' => 0))){
                    if($this->create($data)){
                        DB::commit();
                        Event::dispatch(new AulasAtivasEvent());
                        Event::dispatch(new AulaSalaEvent($data['sala_id']));
                        return true;
                    }
                }

            }else{
                if($this->create($data)){

                    DB::commit();
                    Event::dispatch(new AulasAtivasEvent());
                    Event::dispatch(new AulaSalaEvent($data['sala_id']));
                    return true;
                }
            }
       } catch (Exception $e) {
           DB::rollback();
           throw $e;
       }
       DB::rollback();
       return false;
   }




}
