<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    public $timestamps = false;
    protected $primaryKey = 'id_venta';
    public $incrementing = true;
    protected $fillable = array('id_venta','fecha_venta','estatus','subtotal','total','saldo','id_cliente','id_sucursal','id_usuario','id_forma_de_pago');
}
