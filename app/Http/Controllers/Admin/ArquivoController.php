<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Arquivo\ArquivoRequest;
use App\Models\Arquivo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ArquivoController extends Controller
{
    private $user;
    private $arquivo;
    private $params;

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
        // PARAMS DEFAULT
        $this->params['subtitulo']='Importar Arquivo';
        $this->params['arvore']=[
            [
                'url' => 'admin/arquivo',
                'titulo' => 'Arquivo'
            ],
            [
                'url' => '',
                'titulo' => 'Importar'
            ]];
        $params = $this->params;


        ini_set('memory_limit', '4096M');
        ini_set('post_max_size', '2048M');
        ini_set('max_input_vars', 5000);
        ini_set('max_input_time', 240);
        ini_set('output_buffering', 8192);
        ini_set('max_execution_time', 0);
        ini_set('allow_url_fopen', true);

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

                $titulos = null;
                // REQUIRED FIELDS
                $fields = array("turma_id","ano","nome","numero","data_nascimento","ativo");
                // FLAG FIELDS
                $fields_flag = array("celular","cabine");
                // MAP FIELDS
                $map_fields = NULL;
                // INDICE
                $i=0;
                while (!feof($file_handle)) {
                    $csv = fgetcsv($file_handle, 0,',');

                    if($titulos == null){
                        // MAP FIELDS
                        $map_fields = NULL;
                        // GET TITLES
                        // TO LOWER AND TRIM TITLES
                        $titulos= array_map('trim',array_map('strtolower', $csv));
                        $titulos = preg_replace('/[\x00-\x1F\x80-\xFF]/','', $titulos);
                        foreach($titulos as $indice => $valor){
                            $new_titulos[$indice] = str_replace('"','',$valor);
                        }

                        $titulos = $new_titulos;

                        // VALIDATE FOR REQUIREDS COLUMNS
                        foreach($fields as $v){
                            $v = trim($v);
                            // var_dump($v);
                            if (! in_array(trim($v),$titulos) ) {
                                return redirect()->back()->withErrors(['Erro importar (Coluna '.$v.' faltante no arquivo).']);
                            }
                            $map_fields[$v]=array_search(trim($v),$titulos);
                        }
                        // VALIDADE FOR REQUIREDS COLUMNS
                        $flag=0;
                        foreach($fields_flag as $v){
                            if (in_array(trim($v),$titulos ) ) {
                                $flag++;
                            }
                            $map_fields[$v]=array_search(trim($v),$titulos);

                        }
                        if($flag == 0){
                            return redirect()->back()->withErrors(['Erro importar (Colunas '.implode(", ", $fields_flag).' faltante no arquivo).']);
                        }
                    }elseif(isset($map_fields)){

                        foreach($map_fields as $column => $value){
                            switch($column){
                                case "numero" :
                                    $tmp_data["numero"]= intval($csv[$value]);
                                break;
                                case "cabine" :
                                    $tmp_data["cabine"]= intval($csv[$value]);
                                break;
                                case "nome" :
                                    $tmp_data["name"]= mb_strtoupper($csv[$value]);
                                break;
                                case "data_nascimento" :
                                    $tmp_data["password"]= Hash::make($csv[$value]);
                                break;
                                case 'celular' :
                                    if($csv[$value] != ""){
                                        $tmp_data["send_sms"] = 1;
                                    }
                                    $tmp_data[$column]=$csv[$value];
                                break;
                                case 'ativo' :
                                    if($csv[$value] != ""){
                                        $tmp_data["ativo"] = 1;
                                    }
                                    $tmp_data[$column]=$csv[$value];
                                break;
                                default:
                                    $tmp_data[$column]=$csv[$value];
                                break;
                            }
                        }

                        $aluno = $this->user->where('numero',$tmp_data["numero"])->withTrashed()->first();
                        $tmp_data["importado"] = $id;
                        if($aluno){
                            if($aluno->trashed() ){
                                if($tmp_data["ativo"] == 1){
                                    $aluno->restore();
                                }
                            }
                            if($tmp_data["ativo"] == 1){
                                if(!$aluno->update($tmp_data)){
                                    return redirect()->back()->withErrors(['Erro importar (Atualizar) (Linha '.$i.' => '.implode(", ", $csv).').']);
                                }
                            }else{
                                if(!$aluno->delete()){
                                    return redirect()->back()->withErrors(['Erro importar (Atualizar) (Linha '.$i.' => '.implode(", ", $csv).').']);
                                }
                            }
                        }else{
                            if($tmp_data["ativo"] == 1){
                                if(!$this->user->create($tmp_data)){
                                    return redirect()->back()->withErrors(['Erro importar (Linha '.$i.' => '.implode(", ", $csv).').']);
                                }
                            }

                        }
                        $i++;
                    }else{
                        return redirect()->back()->withErrors(['Erro ao ler o arquivo.']);
                    }

                }
                fclose($file_handle);
                if(!$data->update(['importado' => 1])){
                    return redirect()->back()->withErrors(['Erro modificar status da importação.']);
                }
        }else{
            return redirect()->back()->withErrors(['Arquivo já importado anteriormente.']);
        }

        return view('admin.arquivo.import',compact('params'));
    }

    public function removeImport($id)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Remover Importação';
        $this->params['arvore']=[
           [
               'url' => 'admin/arquivo',
               'titulo' => 'Arquivo'
           ],
           [
               'url' => '',
               'titulo' => 'Remover Importação'
           ]];
        $params = $this->params;
        $params['id']=$id;

        $data = $this->user->where('importado', $id)->get();

        return view('admin.arquivo.remove',compact('data','params'));


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

    public function remove(Request $request)
    {
        $dataForm  = $request->all();

        $data = $this->user->select('id')->where('importado', $dataForm['importado'])->get();

        DB::beginTransaction();
        foreach($data as $i){
            if(! $this->user->find($i['id'])->delete()){
                return redirect()->route($this->params['main_route'].'.removeimport',$dataForm['importado'])->withErrors(['Falha ao deletar.']);
                DB::rollBack();
            }
        }

        DB::commit();

        return redirect()->route($this->params['main_route'].'.removeimport',$dataForm['importado'])->with('Importação deletada com sucesso.');
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
