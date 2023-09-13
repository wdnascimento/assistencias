<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['unidade_id','titulo','status','desc_status','desc_unidade'];

    public function getDescStatusAttribute()
    {
        return $this->status ? 'SIM' : 'NÃO' ;
    }

    public function getDescUnidadeAttribute()
    {
        $unidade = new Unidade();
        return ($unidade = $unidade->select('titulo')->where('id',$this->unidade_id)->first()) ? $unidade->titulo : '';
    }
}
