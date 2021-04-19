<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    public $timestamps = false;
    protected $primaryKey = 'id_servicio';
    public $incrementing = true;
    protected $fillable = array('nombre_completo', 'telefono', 'fecha_servicio',
     'estatus', 'lugar', 'concepto', 'tipo', 'clase',
     'color', 'compania', 'codigo_acceso', 'mojado', 'reparacion_anterior',
     'riesgo', 'notas_tecnicas', 'marca', 'modelo_tecnico', 'IMEI',
     'monto', 'amortizacion', 'por_pagar', 'tipo_pago', 'fecha_pago','notas_extra');

}
