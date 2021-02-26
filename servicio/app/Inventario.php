<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';
    public $timestamps = false;
    protected $primaryKey = 'id_inventario';
    public $incrementing = true;
    protected $fillable = array('id_modelo', 'titulo_inventario', 'descripcion_inventario', 'peso', 'fecha_alta', 'fecha_modificacion', 'costo', 'largo', 'alto', 'ancho', 'upc', 'id_color', 'id_categoria', 'stock', 'stock_min', 'precio_mayoreo', 'precio_min', 'precio_max', 'venta_online', 'imagen');
    protected $casts = [
        'checkOnline' => 'boolean'
    ];
}
