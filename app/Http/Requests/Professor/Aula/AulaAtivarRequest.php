<?php

namespace App\Http\Requests\Professor\Aula;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Professor\ValidarAtivarAula;
use App\Rules\Professor\ValidarAulaProfessor;

class AulaAtivarRequest extends FormRequest
{
    public function rules()
    {
        return [
                'sala_id' => 'required' ,
                'sala_id' => new ValidarAtivarAula,
                'professor_id' => new ValidarAulaProfessor,
        ];
    }

    public function messages()
    {
        return [
            'sala_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'sala_id' => 'Sala' ,
        ];
    }
}
