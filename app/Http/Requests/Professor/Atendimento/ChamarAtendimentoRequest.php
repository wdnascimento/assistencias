<?php

namespace App\Http\Requests\Professor\Atendimento;

use Illuminate\Foundation\Http\FormRequest;

class ChamarAtendimentoRequest extends FormRequest
{
    public function rules()
    {
        return [
                'aula_id' => 'required' ,
        ];
    }

    public function messages()
    {
        return [
            'aula_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'aula_id' => 'Aula' ,
        ];
    }
}
