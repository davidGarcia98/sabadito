<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;
    protected $table = 'persona';
    protected $fillable = ['user_id','nombre','primerApellido','segundoApellido','email','telefono',
        'celular', 'numero_personal', 'rfc', 'curp'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
