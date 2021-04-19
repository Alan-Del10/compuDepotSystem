<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'forma_de_pago';
    public $timestamps = false;
    protected $primaryKey = 'id_forma_de_pago';
    public $incrementing = true;
    protected $fillable = array('forma_pago', 'estatus');
}
