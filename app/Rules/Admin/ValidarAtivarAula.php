<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Aula;

class ValidarAtivarAula implements Rule
{
    public function passes($attribute, $value)
    {
        $aula = new Aula;
        $data = $aula->where('sala_id',$value)->where('status',1)->get();

        if($data->count()){
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'A :attribute selecionada já está ativa para outra Aula. Desative-a antes de cadastrar ativar esta.';
    }

    public function attributes(){
        return [
            'sala_id' => 'Sala'
        ];
    }
}
