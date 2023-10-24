<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = ['unidade_id','titulo','status','desc_status','desc_unidade'];
    protected $appends  = ['desc_status','desc_unidade'];

    public function getDescStatusAttribute()
    {
        return $this->status ? 'SIM' : 'NÃO' ;
    }

    public function getDescUnidadeAttribute()
    {
        $unidade = new Unidade();
        return ($unidade = $unidade->select('titulo')->where('id',$this->unidade_id)->first()) ? $unidade->titulo : '';
    }

    public function getTurmas(){
        return $this->select(DB::raw("CONCAT(unidades.titulo,' - ', turmas.titulo) as titulo"),'turmas.id as id')
                                ->join('unidades','unidades.id','turmas.unidade_id')
                                ->orderBy('unidades.id')
                                ->orderBy('turmas.titulo')
                                ->get()
                                ->pluck('titulo','id');
    }
}
