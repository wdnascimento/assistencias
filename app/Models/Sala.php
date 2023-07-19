<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $fillable = ['turma_id','titulo', 'desc_turma'];

    public function getDescTurmaAttribute(){
        $turma = new Turma();
        return $turma->select('titulo')->where('id',$this->turma_id)->first()->titulo;
    }
}
