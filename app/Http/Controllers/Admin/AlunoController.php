<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TabelaCodes;
use App\Http\Requests\Admin\Aluno\AlunoInsertRequest ;
use App\Http\Requests\Admin\Aluno\AlunoEditarRequest ;
use App\Models\Turma;
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    private $aluno, $turma, $code, $params;

    public function __construct(User $alunos, TabelaCodes $codes, Turma $turmas)
    {
        $this->aluno = $alunos;
        $this->turma = $turmas;

        $this->code = $codes;

        // Default values
        $this->params['titulo']='Aluno';
        $this->params['main_route']='admin.aluno';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Alunos Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/aluno',
                    'titulo' => 'Alunos'
        ];

        $params = $this->params;
        $preload['turma_id'] = $this->turma->getTurmas();
        if($id === null){
            $turma_id = array_key_first($preload['turma_id']->toArray());
        }else{
            $turma_id = intval($id);
        }
        if($turma_id){
            $preload['turma']= $turma_id;
            $data = $this->aluno->with('turma')->where('turma_id',$turma_id)->paginate(20);
        }else{
            $data = null;
        }

        return view('admin.aluno.index',compact('params','data','preload'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Aluno';
        $this->params['arvore']=[
           [
               'url' => 'admin/aluno',
               'titulo' => 'Aluno'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $preload['ano'] = $this->code->where('pai',1)->orderBy('item')->get()->pluck('descricao','valor');
       $preload['turma_id'] = $this->turma->getTurmas();
       return view('admin.aluno.create',compact('params','preload'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlunoInsertRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['password'] = Hash::make($dataForm['password']);

        $insert = $this->aluno->insertValidaCabine($dataForm);

        if($insert){
            return redirect()->route($this->params['main_route'].'.index',$dataForm['turma_id']);
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->params['subtitulo']='Deletar Aluno';
        $this->params['arvore']=[
           [
               'url' => 'admin/aluno',
               'titulo' => 'Aluno'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;
       $preload['ano'] = $this->code->where('pai',1)->orderBy('item')->get()->pluck('descricao','valor');

       $data = $this->aluno->find($id);
       return view('admin.aluno.show',compact('params','data','preload'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->params['subtitulo']='Editar Aluno';
        $this->params['arvore']=[
           [
               'url' => 'admin/aluno',
               'titulo' => 'Aluno'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $preload['ano'] = $this->code->where('pai',1)->orderBy('item')->get()->pluck('descricao','valor');
       $preload['turma_id'] = $this->turma->getTurmas();
       $data = $this->aluno->find($id);
       return view('admin.aluno.create',compact('params', 'data','preload'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlunoEditarRequest $request, $id)
    {
        $data = $this->aluno->find($id);

        $dataForm  = $request->all();
        $dataForm['send_sms'] = (isset($dataForm['send_sms']) ? $dataForm['send_sms'] : 0);

        if(isset($dataForm['trocar_senha_aluno']) && $dataForm['trocar_senha_aluno'] == '1' && $dataForm['password_aluno'] != ''){
            $dataForm['password'] = Hash::make($dataForm['password_aluno']);
        }else{
            unset($dataForm['password']);
        }

        if($data->updateValidaCabine($dataForm,$id)){
            return redirect()->route($this->params['main_route'].'.index',$dataForm['turma_id']);
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->aluno->find($id);
        // Pega a turma para redirecionar
        $turma_id = $data['turma_id'];
        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index',$turma_id);
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }

    public function normalize()
    {
        $data = $this->aluno->all();

        foreach ($data as $key => $value) {
            $dataForm['password'] = Hash::make($value['password']);
            if(! $this->aluno->find($value['id'])->update($dataForm)){
                break;
                return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao normalizar senhas.']);
            }
        }
        return redirect()->route($this->params['main_route'].'.index');
    }
}
