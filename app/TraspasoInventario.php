<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraspasoInventario extends Model
{
    use HasFactory;
    protected $table = 'traspaso_inventario';
    public $timestamps = false;
    protected $primaryKey = 'id_traspaso_inventario';
    public $incrementing = true;
    protected $fillable = array('id_usuario', 'id_sucursal_salida', 'id_sucursal_entrada', 'total_productos', 'razon', 'fecha_traspaso', 'estatus');
}
