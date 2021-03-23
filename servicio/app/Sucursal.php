<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    public $timestamps = false;
    protected $primaryKey = 'id_sucursal';
    public $incrementing = true;
    protected $fillable = array('sucursal', 'direccion', 'local', 'logo', 'politicas', 'tickets', 'etiquetas');
}
