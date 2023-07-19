<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Aula;

class ValidarAulaProfessor implements Rule
{
    public function passes($attribute, $value)
    {
        $aula = new Aula;
        $data = $aula->where('professor_id',$value)->where('status',1)->get();

        if($data->count()){
            return false;
        }
        return true;
    }

    public function message()
    {
        return 'O Professor já esta em uma sala ativa. Desative a sala antes de cadastrar uma nova, ou Cadastre Novamente';
    }

    public function attributes(){
        return [
            'professor_id' => 'Professor'
        ];
    }
}
