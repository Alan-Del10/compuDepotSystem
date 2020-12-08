<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    public $timestamps = false;
    protected $primaryKey = 'id_cliente';
    public $incrementing = true;
    protected $fillable = array('nombre_completo', 'telefono', 'whatsapp', 'correo', 'direccion');
}
