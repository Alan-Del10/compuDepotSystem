<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compra';
    public $timestamps = false;
    protected $primaryKey = 'id_compra';
    public $incrementing = true;
    protected $fillable = array('id_proveedor', 'no_compra', 'fecha_entrada', 'total');
}
