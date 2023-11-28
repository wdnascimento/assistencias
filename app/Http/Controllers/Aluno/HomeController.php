<?php

namespace App\Http\Controllers\Aluno;

use App\Events\PegarSenhaEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Aluno\DesistirSenhaRequest;
use App\Http\Requests\Aluno\PegarSenhaRequest;
use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('aluno.home');
    }
}
