<?php

namespace App\Rules\Aluno;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Atendimento;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ValidarSenha implements Rule
{
    public function passes($attribute, $value)
    {
        $atendimento = new Atendimento;
        $data = $atendimento    ->where('aula_id',$value)
                                ->where('status',0)
                                ->where('user_id',Auth::user()->id)
                                ->get();

        if($data->count()){
            return false;
        }
        return true;
    }

    public function message()
    {
        return [
            'unique' => 'Você já solicitou senha para a :attribute selecionada.'
        ];
    }

    public function attributes(){
        return [
            'sala_id' => 'Sala'
        ];
    }
}
