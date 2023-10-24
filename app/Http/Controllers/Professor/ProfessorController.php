<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Professor\Professor\UpdatePasswordRequest;
use App\Models\Professor;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{
    private $professor, $params, $preload;
    public function __construct(Professor $professores)
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Trocar Senha';
         $this->params['arvore'][0] = [
                     'url' => 'professor/trocarsenha',
                     'titulo' => 'Trocar Senha'
         ];

        $this->professor = $professores;

        $this->params['titulo']='Aula';
        $this->params['main_route']='professor.senha';
    }

    public function showPassword()
    {
        $this->params['subtitulo']='Trocar Senha do Usuário';
        $params = $this->params;

        $data = $this->professor->find(Auth::User()->id);
        return view('professor.professor.trocarsenha',compact('params','data'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $data = $this->professor->find(Auth::User()->id);

        $password = $request->only('password');

        $dataForm['password']  = Hash::make($password['password']);

        if($data->update($dataForm)){
            return redirect()->route('professor.home');
        }else{
            return redirect()->route($this->params['main_route'].'.trocarsenha')->withErrors(['Falha ao trocar a senha.']);
        }
    }
}
