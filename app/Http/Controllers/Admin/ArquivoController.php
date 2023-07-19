<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Arquivo\ArquivoRequest;
use App\Models\Arquivo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ArquivoController extends Controller
{
    public function __construct(Arquivo $arquivos, User $users)
    {

        $this->arquivo = $arquivos;
        $this->user = $users;

        // Default values
        $this->params['titulo']='Arquivo';
        $this->params['main_route']='admin.arquivo';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Arquivo Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/arquivo',
                    'titulo' => 'Arquivo'
        ];

        $params = $this->params;
        $data = $this->arquivo->orderBy('data_hora','desc')->paginate(50);
        return view('admin.arquivo.index',compact('params','data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Arquivo';
        $this->params['arvore']=[
           [
               'url' => 'admin/arquivo',
               'titulo' => 'Arquivo'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;

       $preload = null;
       return view('admin.arquivo.create',compact('params','preload'));
    }

    public function store(ArquivoRequest $request)
    {

        if($request->file()) {
            $fileName = date('YmdHis').'.'.$request->file->getClientOriginalExtension();
            $filePath = $request->file->storeAs('uploads', $fileName,'public');

            //id, titulo, data_hora, importado, usuario,
            $data['titulo'] = $filePath;
            $data['data_hora'] = \Carbon\Carbon::now()->setTimezone('America/Sao_Paulo');
            $data['importado'] = 0;
            $data['usuario'] =Auth()->user()->email;

            $insert = $this->arquivo->create($data);
            if($insert){
                return redirect()->route($this->params['main_route'].'.index');
            }else{
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
            }

        }



    }


    public function import($id)
    {
        $this->params['subtitulo']='Importar Arquivo';
        $this->params['arvore']=[
           [
               'url' => 'admin/arquivo',
               'titulo' => 'Arquivo'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];

        $data = $this->arquivo->find($id);
        if( $data->importado == 0){
            // galerias

                $url = Storage::url($data->titulo);

                $streamSSL = stream_context_create(array(
                    "ssl"=>array(
                        "verify_peer"=> false,
                        "verify_peer_name"=> false
                    )
                ));

                $csv = [];
                $file_handle = fopen(url($url), 'r',false,$streamSSL);
                while (!feof($file_handle)) {
                    $csv[] = fgetcsv($file_handle, 0,',');
                }
                fclose($file_handle);

                // GET TÍTULOS
                $titulos = array_shift($csv);
                // TRIM TITLES
                $titulos= array_map('trim', $titulos);

                // CAMPOS ESPERADOS
                // id, turma_id, ano, name, numero, password, celular, cabine, send_sms
                $fields = array("turma_id","ano","name","numero","celular","data_nascimento");

                // VALIDA COLUNAS NO FILE
                foreach($fields as $i => $v){

                    if (! in_array(trim($v),$titulos ) ) {
                        return redirect()->back()->withErrors(['Erro importar (Coluna '.$v.' faltante no arquivo).']);
                    }

                }

                $tmp_fields = '';
                foreach ($csv as $id => $value){
                    foreach($value as $id2 => $value2){
                        // if(isset($titulos[$id])){
                          $tmp_fields.=$id2. "=> ".   $value2;
                        // }

                    }
                }
                dd($tmp_fields);


        }
        if(!$data->update(['importado' => 1])){
            return redirect()->back()->withErrors(['Erro modificar status da importação.']);
        }

        return redirect()->route($this->params['main_route'].'.index');
    }

    public function update(ArquivoRequest $request, $id)
    {
        $data = $this->arquivo->find($id);

        $dataForm  = $request->all();

        if($data->update($dataForm)){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->arquivo->find($id);

        if($data->delete()){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
