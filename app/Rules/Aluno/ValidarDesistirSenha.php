<?php

namespace App\Rules\Aluno;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Atendimento;
use Illuminate\Support\Facades\Auth;

class ValidarDesistirSenha implements Rule
{
    public function passes($attribute, $value)
    {
        $atendimento = new Atendimento;
        $data = $atendimento    ->where('aula_id',$value)
                                ->where('status',0)
                                ->where('user_id',Auth::user()->id)
                                ->get();

        if($data->count()){
            return true;
        }
        return false;
    }

    public function message()
    {
        return [
            'unique' => 'Você já desistiu da senha para a :attribute selecionada.'
        ];

    }

    public function attributes(){
        return [
            'sala_id' => 'Sala'
        ];
    }
}
