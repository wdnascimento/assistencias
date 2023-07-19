<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Professor;
use App\Http\Requests\Admin\Professor\ProfessorInsertRequest ;
use App\Http\Requests\Admin\Professor\ProfessorUpdateRequest ;

class ProfessorController extends Controller
{
    public function __construct(Professor $professors)
    {
        $this->professor = $professors;

        // Default values
        $this->params['titulo']='Professor';
        $this->params['main_route']='admin.professor';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Professores Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/professor',
                    'titulo' => 'Professores'
        ];

        $params = $this->params;
        $data = $this->professor->all();

        return view('admin.professor.index',compact('params','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Professor';
        $this->params['arvore']=[
           [
               'url' => 'admin/professor',
               'titulo' => 'Professor'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       return view('admin.professor.create',compact('params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfessorInsertRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['password'] = Hash::make($dataForm['password']);

        $insert = $this->professor->create($dataForm);
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
        $this->params['subtitulo']='Deletar Professor';
        $this->params['arvore']=[
           [
               'url' => 'admin/professor',
               'titulo' => 'Professor'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->professor->find($id);
       return view('admin.professor.show',compact('params','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->params['subtitulo']='Editar Professor';
        $this->params['arvore']=[
           [
               'url' => 'admin/professor',
               'titulo' => 'Professor'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->professor->find($id);
       return view('admin.professor.create',compact('params', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfessorUpdateRequest $request, $id)
    {
        $data = $this->professor->find($id);

        $dataForm  = $request->all();

        if($data->update($dataForm)){
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
        $data = $this->professor->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
