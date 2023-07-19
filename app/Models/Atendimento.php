<?php

namespace App\Models;

use App\Events\AulasAtivasEvent;
use App\Events\FilasAtivasEvent;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Aula;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class Atendimento extends Model
{
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

                // SELECIONA O ALUNO QUE É O PROXIMO DA LISTA DE ATENDIMENTO
                $new = $this->select('id','user_id','ordem')->where('aula_id', $dataForm['aula_id'])->where('status',0)->orderBy('ordem')->first();

                if($new){
                    // VERIFICA SE O ALUNO A SER CHAMADO ESTÁ EM ATENDIMENTO
                    $busy = $this->select('id','user_id','ordem')->where('status',1)->where('user_id',$new['user_id'])->first();

                    if($busy){
                        // PROCURA A EXISTENCIA DE PRÓXIMO NA LISTA

                        $next = $this->select('id','user_id','ordem')->where('status',0)->where('ordem','>',$new['ordem'])->where('aula_id', $dataForm['aula_id'])->orderBy('ordem')->first();
                        if($next){
                            // SE EXISTIR TROCA DE POSIÇÃO COM O ALUNO OCUPADO
                            unset($data);
                            $data['status']=1;
                            $data['ordem']=$new['ordem'];
                            $data['hora_atendimento'] =  date("Y-m-d H:i:s");

                            // EFETIVANDO A TROCA DE POSIÇÃO PARTE 1

                            if(!$this->find($next['id'])->update($data)){
                                DB::rollback();
                                return false;
                            }

                            // EFETIVANDO A TROCA DE POSIÇÃO PARTE 1

                            unset($data);
                            $data['ordem']=$next['ordem'];

                            if(!$this->find($new['id'])->update($data)){
                                DB::rollback();
                                return false;
                            }

                        }

                    }else{
                        unset($data);
                        $data['status']=1;
                        $data['hora_atendimento'] =  date("Y-m-d H:i:s");
                        if(!$this->find($new['id'])->update($data)){
                            DB::rollback();
                            return false;
                        }
                    }


                }
            DB::commit();
            Event::dispatch(new AulasAtivasEvent());
            Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
            return true;
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
            Event::dispatch(new AulasAtivasEvent());
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
                $data['status']= '0';
                $aula = new Aula();
                if(! $aula->where('id', $dataForm['aula_id'])->update($data)){
                    DB::rollback();
                    return false;
                }
            DB::commit();
            Event::dispatch(new AulasAtivasEvent());
            Event::dispatch(new FilasAtivasEvent($dataForm['aula_id']));
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function solicitarSenha($data){
         // data ['aula_id' , 'user_id']
        try {
            DB::beginTransaction();
            $data['ordem'] = $this->where('aula_id',$data['aula_id'])->max('ordem') + 1;

            if($this->create($data)){
                DB::commit();
                Event::dispatch(new AulasAtivasEvent());
                Event::dispatch(new FilasAtivasEvent($data['aula_id']));
                return true;
            }

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
                Event::dispatch(new AulasAtivasEvent());
                Event::dispatch(new FilasAtivasEvent($data['aula_id']));
                return true;
            }
       } catch (Exception $e) {
           DB::rollback();
           throw $e;
       }
       return false;
   }

    // Seta - quando ouver - os alunos para atendido se por ventura
    // o professor esquecer de finalizar o atendimento

    public function setAtendido(){
        $atendimentos = $this->select('atendimentos.id as id')->join('aulas','aulas.id','=','atendimentos.aula_id')->where('atendimentos.status',1)->where('aulas.status',0)->get()->pluck('id')->toArray();

        if(is_array($atendimentos) && sizeof($atendimentos)){
            if($this->whereIn('id',$atendimentos)->update(array('status' => 3))){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }

    public function filaAula($aula_id){

        return $this    ->select(   'atendimentos.id','atendimentos.ordem','atendimentos.user_id'
                                    ,'atendimentos.status', 'users.name as nome'
                                    )
                        ->join('users','users.id', 'atendimentos.user_id')
                        ->where('aula_id',$aula_id)
                        ->where('status',0)
                        ->orderBy('ordem')
                        ->get();
    }

}
