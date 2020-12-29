<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    public $timestamps = false;
    protected $primaryKey = 'id_categoria';
    public $incrementing = true;
    protected $fillable = array('descripcion', 'estatus');
}
