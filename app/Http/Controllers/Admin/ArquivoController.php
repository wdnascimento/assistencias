<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Arquivo\ArquivoRequest;
use App\Models\Arquivo;
use App\Models\User;
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
                $fields = array("turma_id","ano","name","numero","data_nascimento");
                // FLAG FIELDS
                $fields_flag = array("celular","cabine");
                // MAP FIELDS
                $map_fields = NULL;
                // INDICE
                $i=0;
                while (!feof($file_handle)) {
                    $csv = fgetcsv($file_handle, 0,',');
                    if($titulos == null){
                        // GET TITLES
                        // TO LOWER AND TRIM TITLES
                        $titulos= array_map('strtolower',array_map('trim', $csv));
                        // VALIDATE FOR REQUIREDS COLUMNS
                        foreach($fields as $v){
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
                    }else{

                        foreach($map_fields as $column => $value){
                            switch($column){
                                case "data_nascimento" :
                                    dd(format_birthday_password($csv[$value]));
                                    $tmp_data["password"]= Hash::make(preg_replace('/[^0-9]/', '', $csv[$value]));
                                break;
                                case 'celular' :
                                    if($csv[$value] != ""){
                                        $tmp_data["send_sms"] = 1;
                                    }
                                    $tmp_data[$column]=$csv[$value];
                                break;
                                default:
                                    $tmp_data[$column]=$csv[$value];
                                break;
                            }
                        }



                        $aluno = $this->user->where('numero',$tmp_data["numero"])->first();
                        if($aluno){
                            if(!$aluno->update($tmp_data)){
                                return redirect()->back()->withErrors(['Erro importar (Atualizar) (Linha '.$i.' => '.implode(", ", $csv).').']);
                            }
                        }else{
                            if(!$this->user->create($tmp_data)){
                                return redirect()->back()->withErrors(['Erro importar (Linha '.$i.' => '.implode(", ", $csv).').']);
                            }

                        }
                        $i++;
                    }
                }
                fclose($file_handle);


            if(!$data->update(['importado' => 1])){
                return redirect()->back()->withErrors(['Erro modificar status da importação.']);
            }

        }else{
            return redirect()->back()->withErrors(['Arquivo já importado anteriormente.']);
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
