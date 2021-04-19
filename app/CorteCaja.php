<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorteCaja extends Model
{
    use HasFactory;
    protected $table = 'corte_caja';
    public $timestamps = false;
    protected $primaryKey = 'id_corte_caja';
    public $incrementing = true;
    protected $fillable = array('is_usuario', 'id_sucursal', 'tipo_corte', 'monto', 'fecha_corte');
}
