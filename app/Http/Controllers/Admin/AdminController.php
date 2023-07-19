<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Http\Requests\Admin\Administrador\AdministradorInsertRequest ;
use App\Http\Requests\Admin\Administrador\AdministradorEditarRequest ;

class AdminController extends Controller
{
    public function __construct(Admin $administradores)
    {
        $this->administrador = $administradores;

        // Default values
        $this->params['titulo']='Administrador';
        $this->params['main_route']='admin.administrador';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Administradores Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/administrador',
                    'titulo' => 'Administradores'
        ];

        $params = $this->params;
        $data = $this->administrador->all();

        return view('admin.administrador.index',compact('params','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Administrador';
        $this->params['arvore']=[
           [
               'url' => 'admin/administrador',
               'titulo' => 'Administrador'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       return view('admin.administrador.create',compact('params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministradorInsertRequest $request)
    {
        $dataForm  = $request->all();

        $dataForm['password'] = Hash::make($dataForm['password']);
        $dataForm['atendimento'] = (!isset($dataForm['atendimento'])?0:$dataForm['atendimento']);

        $insert = $this->administrador->create($dataForm);
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
        $this->params['subtitulo']='Deletar Administrador';
        $this->params['arvore']=[
           [
               'url' => 'admin/administrador',
               'titulo' => 'Administrador'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->administrador->find($id);
       return view('admin.administrador.show',compact('params','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->params['subtitulo']='Editar Administrador';
        $this->params['arvore']=[
           [
               'url' => 'admin/administrador',
               'titulo' => 'Administrador'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->administrador->find($id);
       return view('admin.administrador.create',compact('params', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministradorEditarRequest $request, $id)
    {
        $data = $this->administrador->find($id);

        $dataForm  = $request->all();
        $dataForm['atendimento'] = (!isset($dataForm['atendimento'])?0:$dataForm['atendimento']);

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
        $data = $this->administrador->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
