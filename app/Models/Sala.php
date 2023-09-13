<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
    use SoftDeletes;
    protected $fillable = ['turma_id','titulo', 'desc_turma'];

    public function getDescTurmaAttribute(){
        $turma = new Turma();
        return ($turma = $turma->select('titulo')->where('id',$this->turma_id)->first()) ? $turma->titulo : '';
    }
}
