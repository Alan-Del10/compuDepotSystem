<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    public $timestamps = false;
    protected $primaryKey = 'id_inventario';
    public $incrementing = true;
    protected $fillable = array('id_modelo', 'descripcion_inventario', 'peso', 'fecha_alta', 'fecha_modificacion', 'costo', 'largo', 'alto', 'ancho', 'id_capacidad', 'upc', 'id_color', 'id_categoria', 'stock', 'stock_min', 'precio_publico', 'venta_online');
    protected $casts = [
        'checkOnline' => 'boolean'
    ];
}
