<?php

use App\Http\Controllers\Api\Aluno\AlunoController;
use App\Http\Controllers\Api\Aluno\AtendimentoController;
use App\Http\Controllers\Api\Aluno\AulaController;
use App\Http\Controllers\Api\Aluno\IndexController;
use App\Http\Controllers\Api\Professor\AtendimentoController as ProfessorAtendimentoController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::get('/filaaula/{aula_id}', [AtendimentoController::class,'filaaula'])->name('api.aluno.filaaula');


Route::group(['middleware' => ['auth', 'throttle:500|2200,1']], function () {
    Route::get('/aluno', [IndexController::class,'index'])->name('api.aluno.home');
    Route::post('/pegarsenha', [AlunoController::class,'pegarsenha'])->name('api.aluno.pegarsenha');
    Route::post('/desistirsenha', [AlunoController::class,'desistirsenha'])->name('api.aluno.desistirsenha');
});

Route::group(['middleware' => ['auth:professor', 'throttle:500|2200,1']], function () {
    Route::post('/chamar', [ProfessorAtendimentoController::class,'chamar'])->name('api.professor.chamar');
    Route::post('/pausar', [ProfessorAtendimentoController::class,'pausar'])->name('api.professor.pausar');
    Route::post('/finalizar', [ProfessorAtendimentoController::class,'finalizar'])->name('api.professor.finalizar');
});

 Route::group(['middleware' => ['auth', 'throttle:500|2200,1']], function () {
    Route::post('/broadcasting/auth',function(){
    //     //         $data['token'] = "O0efhw.66yhMg:MX-caD_8538xWhoSSCRb_wSjJX_1MfgQWpJD5sVEwS8";
    //     // //     $tmp['code'] = 200;
    //     // //     $tmp['auth'] = $data;
    //     // //     return response([ 'data' => $tmp ],200);
            return true;
    });


});

Route::post('endpoint/auth', function () {
    return response(true ,200);;
});

