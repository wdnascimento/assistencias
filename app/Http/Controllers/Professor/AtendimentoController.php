<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Atendimento;
use App\Models\Aula;
use App\Models\Sala;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Professor\Atendimento\ChamarAtendimentoRequest;

class AtendimentoController extends Controller
{
    public function __construct(Atendimento $atendimentos, Aula $aulas, Sala $salas, User $alunos)
    {
        $this->atendimento = $atendimentos;
        $this->aula = $aulas;
        $this->sala = $salas;
        $this->aluno = $alunos;

        // Default values
        $this->params['titulo']='Atendimento';
        $this->params['main_route']='professor.atendimento';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Atendimentos';
        $this->params['arvore'][0] = [
                    'url' => 'admin/atendimento',
                    'titulo' => 'Atendimento'
        ];

        $params = $this->params;


        /*
            SELECT * FROM atendimentos at
                INNER JOIN aulas au
                ON au.id = at.aula_id
                WHERE au.sala_id = 2
                AND au.status = 1
                AND au.status IN (0,1)
                ORDER BY at.ordem, at.status desc
        */

        $data['sala_ativa'] =  DB::table('aulas','au')
                                    ->join('salas as sa','sa.id', 'au.sala_id')
                                    ->select('sa.titulo as titulo', 'au.sala_id as sala_id' , 'au.id as aula_id' )
                                    ->where('au.status',1)
                                    ->where('au.professor_id', Auth::User()->id)->first();

        if($data['sala_ativa']){
            $data['espera'] = DB::table('atendimentos','at')
                ->join('aulas as au', 'au.id', '=', 'at.aula_id')
                ->join('users as us', 'us.id' , 'at.user_id')
                ->join('disciplinas as di', 'di.id' , 'au.disciplina_id')
                ->join('professors as pr', 'pr.id' , 'au.professor_id')
                ->select('at.aula_id as aula_id', 'au.sala_id as sala_id' , DB::raw("SUBSTRING_INDEX(pr.name, ' ', 1) as professor"),  DB::raw("SUBSTRING_INDEX(us.name, ' ', 1) as nome"), 'at.status as status', 'us.name as nome_completo', 'us.numero as numero', 'us.cabine as cabine', 'di.titulo as titulo_disciplina')
                ->where('au.sala_id',$data['sala_ativa']->sala_id )
                ->where('au.status',1)
                ->whereIn('at.status',[0,1])
                ->orderBy('at.ordem')
                ->orderBy('at.status', 'desc')
                ->paginate(5);
        }


        return view('professor.atendimento.index',compact('params','data'));
    }

    public function chamar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

       $dataForm  = $request->all();

        if($this->atendimento->chamarProximo($dataForm['aula_id'])){


            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.chamar')->withErrors(['Falha ao editar.']);
        }


    }

    public function pausar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

        $dataForm  = $request->all();

        if($this->atendimento->pausarAtendimento($dataForm['aula_id'])){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao pausar.']);
        }


    }

    public function finalizar(ChamarAtendimentoRequest  $request)
    {

         // PARAMS DEFAULT
         $this->params['subtitulo']='Atendimentos';
         $this->params['arvore'][0] = [
                     'url' => 'admin/atendimento',
                     'titulo' => 'Atendimento'
         ];

        $params = $this->params;

        $dataForm  = $request->all();

        if($this->atendimento->finalizarAtendimento($dataForm['aula_id'])){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao finalizar atendimento.']);
        }


    }



}
