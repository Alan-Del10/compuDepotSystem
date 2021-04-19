<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    public $timestamps = false;
    protected $primaryKey = 'id_venta';
    public $incrementing = true;
    protected $fillable = array('fecha_venta','estatus','subtotal','iva','total','id_cliente','id_sucursal','id_usuario','id_usuario_cliente');
}
