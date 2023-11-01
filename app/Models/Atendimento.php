<?php

namespace App\Models;

use App\Events\AulaSalaEvent;
use App\Events\AulasAtivasEvent;
use App\Events\FilasAtivasEvent;
use App\Events\PainelSalaEvent;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Aula;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class Atendimento extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'aula_id', 'user_id','ordem','status','hora_solicitacao','hora_atendimento', 'hora_termino'];

    public function aula(){
        return $this->hasMany(Aula::class);
    }

    public function aluno(){
        return $this->hasMany(User::class);
    }


    public function chamarProximo($dataForm){
        try {
            DB::beginTransaction();
                $response = [];
                // SELECIONA O ALUNO QUE ESTÁ EM ATENDIMENTO
                $current = $this->select('id')->where('aula_id', $dataForm['aula_id'])->where('status',1)->first();
                if($current){
                    $data['status']= '2';
                    $data['hora_termino'] =  date("Y-m-d H:i:s");
                    // ALTERA O STATUS PARA ATENDIDO

                    if(! $this->find($current['id'])->update($data)){
                        DB::rollback();
                        $response['result'] = false;
                        return $response;
                    }
                }

                // SELECIONA O ALUNO QUE É O PROXIMO DA LISTA DE ATENDIMENTO
                $new = $this->select('id','user_id','aula_id','ordem')->where('aula_id', $dataForm['aula_id'])->where('status',0)->orderBy('ordem')->first();

                if($new){

                    unset($data);
                    $data['status']=1;
                    $data['hora_atendimento'] =  date("Y-m-d H:i:s");
                    if(!$this->find($new['id'])->update($data)){
                        DB::rollback();
                        $response['result'] = false;
                        return $response;
                    }
                    $user = new User();
                    $response['aluno'] =  $user->find($new['user_id']) ;
                    $aula = new Aula();
                    $response['aula'] =  $aula->with('professor')->with('disciplina')->with('sala')->find($new['aula_id']) ;
                }else{
                    $response['aluno_id'] = null;
                }
                DB::commit();
                $aula = new Aula();
                $aula = $aula->select('sala_id')->where('id',$dataForm['aula_id'])->first();
                Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($dataForm['aula_id'])));
                Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
                // PAINEL
                $sala = new Sala();
                $sala = $sala->select('turma_id')->where('id',$aula['sala_id'])->first();
                Event::dispatch(new PainelSalaEvent($sala['turma_id']));
                $response['result'] = true;
                return $response;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function pausarAtendimento($dataForm){
        try {
            DB::beginTransaction();
                // SELECIONA O ALUNO QUE ESTÁ EM ATENDIMENTO
                $current = $this->select('id')->where('aula_id', $dataForm['aula_id'])->where('status',1)->first();
                if($current){
                    $data['status']= '2';
                    $data['hora_termino'] =  date("Y-m-d H:i:s");
                    // ALTERA O STATUS PARA ATENDIDO

                    if(! $this->find($current['id'])->update($data)){
                        DB::rollback();
                        return false;
                    }
                }

            DB::commit();

            $aula = new Aula();
            $aula = $aula->select('sala_id')->where('id',$dataForm['aula_id'])->first();
            Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($dataForm['aula_id'])));
            Event::dispatch(new AulaSalaEvent($aula['sala_id']));
            Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function finalizarAtendimento($dataForm){
        try {

            DB::beginTransaction();
                $aula = new Aula();
                // testa se a aula está ativa e pega a sala_id
                if($aula = $aula->select('sala_id','status')->where('id',$dataForm['aula_id'])->first()){
                    if($aula['status'] == 1){
                        // SELECIONA O ALUNO QUE ESTÁ EM ATENDIMENTO
                        $current = $this->select('id')->where('aula_id', $dataForm['aula_id'])->where('status',1)->first();
                        if($current){
                            $data['status']='2';
                            $data['hora_termino'] =  date("Y-m-d H:i:s");
                            // ALTERA O STATUS PARA ATENDIDO
                            if(! $this->find($current['id'])->update($data)){
                                DB::rollback();
                                return false;
                            }
                        }
                        unset($data);

                        // SELECIONA OS ALUNOS QUE SOLICITARAM SENHAS ATENDIMENTO
                        $current = $this->select('id')->where('aula_id', $dataForm['aula_id'])->where('status',0)->get();
                        foreach($current as $item){
                            if($item){
                                $data['status']='3';
                                // ALTERA O STATUS PARA ATENDIDO
                                if(! $this->find($item->id)->update($data)){
                                    DB::rollback();
                                    return false;
                                }
                            }
                        }
                        unset($data);

                        $data['status']= '0';
                        $data['fim'] =  date("Y-m-d H:i:s");
                        if(! $aula->find($dataForm['aula_id'])->update($data)){
                            DB::rollback();
                            return false;
                        }
                        DB::commit();
                        Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($dataForm['aula_id'])));
                        Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                        Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
                        return true;
                    }
                }
                DB::rollback();

                Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($dataForm['aula_id'])));
                Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
                return false;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function solicitarSenha($data){
        // data ['aula_id' , 'user_id']
        try {
            DB::beginTransaction();
            $aula = new Aula();
            // testa se a aula está ativa e pega a sala_id
            if($aula = $aula->select('sala_id','status')->where('id',$data['aula_id'])->first()){
                if($aula['status'] == '1' && ($this->where('aula_id',$data['aula_id'])->where('user_id',$data['user_id'])->where('status',1)->first() == NULL)){
                    $data['ordem'] = $this->where('aula_id',$data['aula_id'])->withTrashed()->max('ordem') + 1;
                    if($this->create($data)){
                        DB::commit();
                        Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($data['aula_id'])));
                        Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                        Event::dispatch(new FilasAtivasEvent($data['aula_id']));
                        return true;
                    }
                }
                DB::rollback();

                Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($data['aula_id'])));
                Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                Event::dispatch(new FilasAtivasEvent($data['aula_id']));
                return false;

            }
            Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($data['aula_id'])));
            Event::dispatch(new FilasAtivasEvent($data['aula_id']));
            DB::rollback();
            return false;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        return false;
    }

    public function desistirSenha($data){
        // data ['aula_id' , 'user_id']
       try {
            DB::beginTransaction();

            $tmp = $this->where('aula_id',$data['aula_id'])
                        ->where('status',0)
                        ->where('user_id',Auth::user()->id)
                        ->first();
            if($tmp){
                $this->find($tmp->id)->delete();

                DB::commit();
                $aula = new Aula();
                $aula =$aula->select('sala_id')->where('id',$data['aula_id'])->first();
                // testa se a aula está ativa e pega a sala_id
                Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($data['aula_id'])));
                Event::dispatch(new AulaSalaEvent($aula['sala_id']));
                Event::dispatch(new FilasAtivasEvent($data['aula_id']));
                return true;
            }
            $aula = new Aula();
            $aula =$aula->select('sala_id')->where('id',$data['aula_id'])->first();
            // testa se a aula está ativa e pega a sala_id

            Event::dispatch(new AulasAtivasEvent($aula->aulaTurma($data['aula_id'])));
            Event::dispatch(new AulaSalaEvent($aula['sala_id']));
            Event::dispatch(new FilasAtivasEvent($data['aula_id']));
            return false;

       } catch (Exception $e) {
           DB::rollback();
           throw $e;
       }
   }

    public function filaAula($aula_id){

        return $this ->select(   'atendimentos.id','atendimentos.ordem','atendimentos.user_id'
                                    ,'atendimentos.status',
                                    DB::raw("(SUBSTRING_INDEX(users.name, ' ', 1)) as nome"))
                        ->join('users','users.id', 'atendimentos.user_id')
                        ->where('aula_id',$aula_id)
                        ->where('status',0)
                        ->orderBy('ordem')
                        ->get();
    }

    public function painelAtendimentoSala($sala_id){

        return $this->select(DB::raw("(SUBSTRING_INDEX(users.name, ' ', 1)) as aluno"),'users.numero as numero', 'users.cabine as cabine','atendimentos.ordem as senha'
                                , DB::raw("(SUBSTRING_INDEX(professors.name, ' ', 1)) as professor")
                                , 'disciplinas.titulo as disciplina', 'salas.titulo as sala')
                    ->join('users','users.id', 'atendimentos.user_id')
                    ->join('aulas','aulas.id', 'atendimentos.aula_id')
                    ->join('professors','professors.id', 'aulas.professor_id')
                    ->join('disciplinas','disciplinas.id', 'aulas.disciplina_id')
                    ->join('salas','salas.id', 'aulas.sala_id')
                    ->where('salas.turma_id',$sala_id)
                    ->orderBy('hora_atendimento','desc')
                    ->limit(10)
                    ->get();
    }

}
