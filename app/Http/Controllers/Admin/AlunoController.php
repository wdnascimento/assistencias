<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\TabelaCodes;
use App\Http\Requests\Admin\Aluno\AlunoInsertRequest ;
use App\Http\Requests\Admin\Aluno\AlunoEditarRequest ;

class AlunoController extends Controller
{

    public function __construct(User $alunos, TabelaCodes $codes)
    {
        $this->aluno = $alunos;

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
    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Alunos Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/aluno',
                    'titulo' => 'Alunos'
        ];

        $params = $this->params;
        $data = $this->aluno->paginate(20);

        return view('admin.aluno.index',compact('params','data'));
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
            return redirect()->route($this->params['main_route'].'.index');
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

        if(isset($dataForm['trocar_senha_aluno']) && $dataForm['trocar_senha_aluno'] == '1' && $dataForm['password_aluno'] != ''){
            $dataForm['password'] = Hash::make($dataForm['password_aluno']);
        }else{
            unset($dataForm['password']);
        }


        if($data->updateValidaCabine($dataForm,$id)){
            return redirect()->route($this->params['main_route'].'.index');
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

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
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
