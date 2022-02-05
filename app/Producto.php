<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    protected $table = 'producto';
    protected $fillable = ['nombre','precio','categoria','descripcion','marca','stockMin',
        'stockMax','stockExistente'];
}
