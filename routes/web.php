<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AlunoController;
use App\Http\Controllers\Admin\ArquivoController;
use App\Http\Controllers\Admin\AtendimentoController as AdminAtendimentoController;
use App\Http\Controllers\Admin\AulaController as AdminAulaController;
use App\Http\Controllers\Admin\DisciplinaController;
use App\Http\Controllers\Admin\GrupoDisciplinaController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\SalaController;
use App\Http\Controllers\Admin\TurmaController;
use App\Http\Controllers\Admin\UnidadeController;
use App\Http\Controllers\Aluno\HomeController as AlunoHomeController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Auth\Professor\LoginController as ProfessorLoginController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\Professor\AtendimentoController;
use App\Http\Controllers\Professor\AulaController;
use App\Http\Controllers\Professor\IndexController as ProfessorIndexController;
use App\Http\Controllers\Professor\ProfessorController as ProfessorProfessorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route as Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('welcome');
});

Route::group(['prefix' => 'aluno'], function(){
    Auth::routes();
    Route::post('login', [AuthLoginController::class, 'postLogin'])->name('aluno.login.post');
});

Route::group(['prefix' => 'aluno','middleware' => 'auth','namespace' => 'Aluno'], function(){
    Route::get('/', [AlunoHomeController::class,'index'])->name('aluno.home');
    Route::get('home', [AlunoHomeController::class,'index'])->name('aluno.home.index');
    Route::post('pegarsenha',[AlunoHomeController::class,'pegarsenha'])->name('aluno.pegarsenha');
    Route::post('desistirsenha',[AlunoHomeController::class,'desistirsenha'])->name('aluno.desistirsenha');
});
// END ALUNO ROUTES


// TEACHERS ROUTES

Route::group(['prefix' => 'professor', 'namespace' => 'Auth/Professor'], function(){

    Route::get('login', [ProfessorLoginController::class,'login'])->name('professor.auth.login');
    Route::post('login', [ProfessorLoginController::class,'loginProfessor'])->name('professor.auth.loginProfessor');
    Route::post('logout',[ProfessorLoginController::class,'logout'])->name('professor.auth.logout');
});

Route::group(['prefix' => 'professor','middleware' => 'auth:professor','namespace' => 'Professor'], function(){
    Route::get('/', [ProfessorIndexController::class,'index'])->name('professor.home');
    Route::get('home', [ProfessorIndexController::class,'index'])->name('professor.dashboard');

     // Professor password
    Route::get('trocarsenha', [ProfessorProfessorController::class,'showPassword'])->name('professor.senha.trocarsenha');
    Route::put('updatepassword', [ProfessorProfessorController::class,'updatePassword'])->name('professor.senha.updatepassword');


    // Atendimento
    Route::get('atendimento', [AtendimentoController::class,'index'])->name('professor.atendimento.index');
    Route::get('atendimento/unidade/{unidade_id}', [AtendimentoController::class,'unidade'])->name('professor.atendimento.unidade');
    Route::get('atendimento/unidade/{unidade_id}/turma/{turma_id}', [AtendimentoController::class,'turma'])->name('professor.atendimento.turma');
    Route::get('atendimento/unidade/{unidade_id}/turma/{turma_id}/sala/{sala_id}', [AtendimentoController::class,'sala'])->name('professor.atendimento.sala');
    Route::post('atendimento/chamar/', [AtendimentoController::class,'chamar'])->name('professor.atendimento.chamar');
    Route::post('atendimento/pausar/', [AtendimentoController::class,'pausar'])->name('professor.atendimento.pausar');
    Route::post('atendimento/finalizar/', [AtendimentoController::class,'finalizar'])->name('professor.atendimento.finalizar');
    //Aula
    Route::get('aula', [AulaController::class,'index'])->name('professor.aula.index');
    Route::get('aula/create', [AulaController::class,'create'])->name('professor.aula.create');
    Route::post('aula/store', [AulaController::class,'store'])->name('professor.aula.store');
    Route::post('aula/ativar/{id}', [AulaController::class,'ativar'])->name('professor.aula.ativar');
    Route::post('aula/desativar/{id}', [AulaController::class,'desativar'])->name('professor.aula.desativar');
});

// END TEACHER ROUTES


// ADMIN ROUTES

Route::group(['prefix' => 'admin', 'namespace' => 'Auth\Admin'], function(){
    // NOT AVALIABLE
    Route::get('password/reset', [LoginController::class,'login'])->name('professor.password.reset');

    Route::get('login', [LoginController::class,'login'])->name('admin.auth.login');
    Route::post('login', [LoginController::class,'loginAdmin'])->name('admin.auth.loginAdmin');
    Route::post('logout',[LoginController::class,'logout'])->name('admin.auth.logout');
});

// END ADMIN ROUTES

// Route::get('admin/salas', [AdminIndexController::class,'salas'])->name('admin.salas');

Route::group(['prefix' => 'admin','middleware' => 'auth:admin','namespace' => 'Admin'],function(){

    // HOME
    Route::get('/', [IndexController::class,'index'])->name('admin.home');
    Route::get('home', [IndexController::class,'index'])->name('admin.dashboard');

    // Atendimento
    // Route::get('atendimento', [AdminAtendimentoController::class,'index'])->name('admin.atendimento.index');

    Route::get('atendimento', [AdminAtendimentoController::class,'index'])->name('admin.atendimento.index');
    Route::get('atendimento/unidade/{unidade_id}', [AdminAtendimentoController::class,'unidade'])->name('admin.atendimento.unidade');
    Route::get('atendimento/unidade/{unidade_id}/turma/{turma_id}', [AdminAtendimentoController::class,'turma'])->name('admin.atendimento.turma');
    Route::get('atendimento/unidade/{unidade_id}/turma/{turma_id}/salas/{sala_id}', [AdminAtendimentoController::class,'salas'])->name('admin.atendimento.sala');

    // CRUDS

    //Disciplina
    Route::get('disciplina', [DisciplinaController::class,'index'])->name('admin.disciplina.index');
    Route::get('disciplina/create', [DisciplinaController::class,'create'])->name('admin.disciplina.create');
    Route::post('disciplina/store', [DisciplinaController::class,'store'])->name('admin.disciplina.store');
    Route::get('disciplina/edit/{id}', [DisciplinaController::class,'edit'])->name('admin.disciplina.edit');
    Route::get('disciplina/show/{id}', [DisciplinaController::class,'show'])->name('admin.disciplina.show');
    Route::put('disciplina/update/{id}', [DisciplinaController::class,'update'])->name('admin.disciplina.update');
    Route::delete('disciplina/destroy/{id}', [DisciplinaController::class,'destroy'])->name('admin.disciplina.destroy');

    //Grupo Disciplina
    Route::get('grupo_disciplina', [GrupoDisciplinaController::class,'index'])->name('admin.grupo_disciplina.index');
    Route::get('grupo_disciplina/create', [GrupoDisciplinaController::class,'create'])->name('admin.grupo_disciplina.create');
    Route::post('grupo_disciplina/store', [GrupoDisciplinaController::class,'store'])->name('admin.grupo_disciplina.store');
    Route::get('grupo_disciplina/edit/{id}', [GrupoDisciplinaController::class,'edit'])->name('admin.grupo_disciplina.edit');
    Route::get('grupo_disciplina/show/{id}', [GrupoDisciplinaController::class,'show'])->name('admin.grupo_disciplina.show');
    Route::put('grupo_disciplina/update/{id}', [GrupoDisciplinaController::class,'update'])->name('admin.grupo_disciplina.update');
    Route::delete('grupo_disciplina/destroy/{id}', [GrupoDisciplinaController::class,'destroy'])->name('admin.grupo_disciplina.destroy');

     //Sala
    Route::get('sala', [SalaController::class,'index'])->name('admin.sala.index');
    Route::get('sala/create', [SalaController::class,'create'])->name('admin.sala.create');
    Route::post('sala/store', [SalaController::class,'store'])->name('admin.sala.store');
    Route::get('sala/edit/{id}', [SalaController::class,'edit'])->name('admin.sala.edit');
    Route::get('sala/show/{id}', [SalaController::class,'show'])->name('admin.sala.show');
    Route::put('sala/update/{id}', [SalaController::class,'update'])->name('admin.sala.update');
    Route::delete('sala/destroy/{id}', [SalaController::class,'destroy'])->name('admin.sala.destroy');

    //Admin
    Route::get('administrador', [AdminController::class,'index'])->name('admin.administrador.index');
    Route::get('administrador/create', [AdminController::class,'create'])->name('admin.administrador.create');
    Route::post('administrador/store', [AdminController::class,'store'])->name('admin.administrador.store');
    Route::get('administrador/edit/{id}', [AdminController::class,'edit'])->name('admin.administrador.edit');
    Route::get('administrador/show/{id}', [AdminController::class,'show'])->name('admin.administrador.show');
    Route::put('administrador/update/{id}', [AdminController::class,'update'])->name('admin.administrador.update');
    Route::delete('administrador/destroy/{id}', [AdminController::class,'destroy'])->name('admin.administrador.destroy');

    //Aluno
    Route::get('aluno/index/{turma_id?}', [AlunoController::class,'index'])->name('admin.aluno.index');
    Route::get('aluno/create', [AlunoController::class,'create'])->name('admin.aluno.create');
    Route::post('aluno/store', [AlunoController::class,'store'])->name('admin.aluno.store');
    Route::get('aluno/edit/{id}', [AlunoController::class,'edit'])->name('admin.aluno.edit');
    Route::get('aluno/show/{id}', [AlunoController::class,'show'])->name('admin.aluno.show');
    Route::put('aluno/update/{id}', [AlunoController::class,'update'])->name('admin.aluno.update');
    Route::delete('aluno/destroy/{id}', [AlunoController::class,'destroy'])->name('admin.aluno.destroy');

    Route::get('aluno/normalize', [AlunoController::class,'normalize'])->name('admin.aluno.normalize');

    //Aula
    Route::get('aula', [AdminAulaController::class,'index'])->name('admin.aula.index');
    Route::get('aula/create', [AdminAulaController::class,'create'])->name('admin.aula.create');
    // Route::post('aula/store', [AdminAulaController::class,'store'])->name('admin.aula.store');
    Route::post('aula/ativar/{id}', [AdminAulaController::class,'ativar'])->name('admin.aula.ativar');
    Route::post('aula/desativar/{id}', [AdminAulaController::class,'desativar'])->name('admin.aula.desativar');

    //Arquivo
    Route::get('arquivo', [ArquivoController::class,'index'])->name('admin.arquivo.index');
    Route::get('arquivo/create', [ArquivoController::class,'create'])->name('admin.arquivo.create');
    Route::post('arquivo/store', [ArquivoController::class,'store'])->name('admin.arquivo.store');
    Route::get('arquivo/import/{id}', [ArquivoController::class,'import'])->name('admin.arquivo.import');
    Route::get('arquivo/show/{id}', [ArquivoController::class,'show'])->name('admin.arquivo.show');
    Route::put('arquivo/update/{id}', [ArquivoController::class,'update'])->name('admin.arquivo.update');
    Route::delete('arquivo/destroy/{id}', [ArquivoController::class,'destroy'])->name('admin.arquivo.destroy');


    //Professor
    Route::get('professor', [ProfessorController::class,'index'])->name('admin.professor.index');
    Route::get('professor/create', [ProfessorController::class,'create'])->name('admin.professor.create');
    Route::post('professor/store', [ProfessorController::class,'store'])->name('admin.professor.store');
    Route::get('professor/edit/{id}', [ProfessorController::class,'edit'])->name('admin.professor.edit');
    Route::get('professor/show/{id}', [ProfessorController::class,'show'])->name('admin.professor.show');
    Route::put('professor/update/{id}', [ProfessorController::class,'update'])->name('admin.professor.update');
    Route::delete('professor/destroy/{id}', [ProfessorController::class,'destroy'])->name('admin.professor.destroy');


    //Turma
    Route::get('turma', [TurmaController::class,'index'])->name('admin.turma.index');
    Route::get('turma/edit/{id}', [TurmaController::class,'edit'])->name('admin.turma.edit');
    Route::put('turma/update/{id}', [TurmaController::class,'update'])->name('admin.turma.update');
    Route::get('turma/show/{id}', [TurmaController::class,'show'])->name('admin.turma.show');
    Route::get('turma/create', [TurmaController::class,'create'])->name('admin.turma.create');
    Route::post('turma/store', [TurmaController::class,'store'])->name('admin.turma.store');
    Route::post('turma/ativar/{id}', [TurmaController::class,'ativar'])->name('admin.turma.ativar');
    Route::post('turma/desativar/{id}', [TurmaController::class,'desativar'])->name('admin.turma.desativar');

    //Unidade
    Route::get('unidade', [UnidadeController::class,'index'])->name('admin.unidade.index');
    Route::get('unidade/edit/{id}', [UnidadeController::class,'edit'])->name('admin.unidade.edit');
    Route::put('unidade/update/{id}', [UnidadeController::class,'update'])->name('admin.unidade.update');
    Route::get('unidade/show/{id}', [UnidadeController::class,'show'])->name('admin.unidade.show');
    Route::get('unidade/create', [UnidadeController::class,'create'])->name('admin.unidade.create');
    Route::post('unidade/store', [UnidadeController::class,'store'])->name('admin.unidade.store');
    Route::post('unidade/ativar/{id}', [UnidadeController::class,'ativar'])->name('admin.unidade.ativar');
    Route::post('unidade/desativar/{id}', [UnidadeController::class,'desativar'])->name('admin.unidade.desativar');
});

Route::get('test', function () {
    event(new App\Events\PainelSalaEvent(1));
    return "Event has been sent!";
});

// Auth::routes();

Route::get('/home', [ControllersHomeController::class, 'index'])->name('home');
