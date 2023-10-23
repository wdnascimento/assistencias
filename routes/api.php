<?php

use App\Http\Controllers\Api\Admin\AtendimentoController as AdminAtendimentoController;
use App\Http\Controllers\Api\Aluno\AlunoController;
use App\Http\Controllers\Api\Aluno\AtendimentoController;
use App\Http\Controllers\Api\Aluno\AulaController;
use App\Http\Controllers\Api\Aluno\IndexController;
use App\Http\Controllers\Api\Professor\AtendimentoController as ProfessorAtendimentoController;
use App\Http\Controllers\Api\Professor\AulaController as ProfessorAulaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/aulasativas', [AulaController::class,'ativas'])->name('api.aulas.ativas');
Route::get('/aulasala/{aula_id}', [AulaController::class,'aulasala'])->name('api.aula.sala');
Route::get('/filaaula/{aula_id}', [AtendimentoController::class,'filaaula'])->name('api.aluno.filaaula');
Route::get('/painelsala/{sala_id}', [AdminAtendimentoController::class,'painel'])->name('api.admin.painel');


Route::group(['middleware' => ['auth', 'throttle:2200,1']], function () {
    Route::get('/aluno', [IndexController::class,'index'])->name('api.aluno.home');
    Route::post('/pegarsenha', [AlunoController::class,'pegarsenha'])->name('api.aluno.pegarsenha');
    Route::post('/desistirsenha', [AlunoController::class,'desistirsenha'])->name('api.aluno.desistirsenha');
});

// Route::group(['middleware' => ['auth:admin', 'throttle:2200,1']], function () {
// });

Route::group(['middleware' => ['auth:professor', 'throttle:2200,1']], function () {
    Route::post('/cadastraraula', [ProfessorAulaController::class,'cadastraraula'])->name('api.professor.cadastraraula');
    Route::post('/chamar', [ProfessorAtendimentoController::class,'chamar'])->name('api.professor.chamar');
    Route::post('/pausar', [ProfessorAtendimentoController::class,'pausar'])->name('api.professor.pausar');
    Route::post('/finalizar', [ProfessorAtendimentoController::class,'finalizar'])->name('api.professor.finalizar');
    Route::get('/getAluno', [ProfessorAtendimentoController::class,'getAluno'])->name('api.professor.aluno');
});

 Route::group(['middleware' => ['auth', 'throttle:2200,1']], function () {
    Route::post('/broadcasting/auth',function(){
            return true;
    });


});

Route::post('endpoint/auth', function () {
    return response(true ,200);;
});

