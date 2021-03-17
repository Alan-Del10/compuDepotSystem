<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraGeneral extends Model
{
    use HasFactory;

    protected $table = 'bitacora_general';
    public $timestamps = false;
    protected $primaryKey = 'id_log';
    public $incrementing = true;
    protected $fillable = array('fecha_log_general','descripcion_log_general','id_usuario','id_sucursal');
}
