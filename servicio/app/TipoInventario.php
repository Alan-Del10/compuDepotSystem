<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoInventario extends Model
{
    protected $table = 'tipo_inventario';
    public $timestamps = false;
    protected $primaryKey = 'id_tipo_inventario';
    public $incrementing = true;
    protected $fillable = array('descripcion');
}
