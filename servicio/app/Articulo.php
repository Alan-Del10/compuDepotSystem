<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulo';
    public $timestamps = false;
    protected $primaryKey = 'id_articulo';
    public $incrementing = true;
    protected $fillable = array('id_marca', 'id_modelo', 'descripcion', 'peso', 'fecha_alta', 'costo_promedio', 'largo', 'alto', 'ancho', 'id_capacidad');
}
