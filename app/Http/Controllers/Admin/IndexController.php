<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Professor;
use App\Models\Aula;
use Illuminate\Support\Facades\Response;

//use App\Models\Atendimento;

class IndexController extends Controller
{
    public function __construct(Admin $administradores,User $alunos,Professor $professors,Aula $aulas)
    {
        $this->administrador = $administradores;
        $this->aluno = $alunos;
        $this->professor = $professors;
        $this->aula = $aulas;
        //$this->atendimento = $atendimentos;
        

        // Default values
        $this->params['titulo']='Bem Vindo';
        $this->params['main_route']='admin';
 
    }


    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='';
        
        $params = $this->params;
        $data['admin'] = $this->administrador->count();
        $data['aluno'] = $this->aluno->count();
        $data['professor'] = $this->professor->count();
        $data['aula'] = $this->aula->count();
      //  $data['atendimentos'] = $this->administrador->count();
        
        return view('admin.index',compact('params','data'));
    }


    public function salas(){
        
        return Response()->json($this->aula->all());
    }



    
    
}
