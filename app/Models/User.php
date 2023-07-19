<?php

namespace App\Models ;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'numero', 'cabine','ano'
    ];

    protected $hidden = [
        'password',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function insertValidaCabine($data){
        try {
            DB::beginTransaction();
            // PROCURA ALUNO NESTA CABINE
            $cabines = $this->select('id')->where('cabine',$data['cabine'])->where('ano',$data['ano'])->get()->pluck('id')->toArray();
            if($cabines != null){
                if(! $this->whereIn('id',$cabines)->update(array('cabine' => '99'))){
                    DB::rollback();
                    return false;
                }
            }
            if(!$this->create($data)){
                DB::rollback();
                return false;
            }
       } catch (Exception $e) {
           DB::rollback();
           throw $e;
       }
       DB::commit();
       return true;

    }

    public function updateValidaCabine($data,$id){
        try {
            DB::beginTransaction();
            // PROCURA ALUNO NESTA CABINE
            $cabines = $this->select('id')->where('cabine',$data['cabine'])->where('ano',$data['ano'])->where('id','<>',$id)->get()->pluck('id')->toArray();
            if($cabines != null){
                if(! $this->whereIn('id',$cabines)->update(array('cabine' => '99'))){
                    DB::rollback();
                    return false;
                }
            }
            if(!$this->find($id)->update($data)){
                DB::rollback();
                return false;
            }
       } catch (Exception $e) {
           DB::rollback();
           throw $e;
       }
       DB::commit();
       return true;

    }

}
