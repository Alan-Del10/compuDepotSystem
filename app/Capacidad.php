<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capacidad extends Model
{
    protected $table = 'capacidad';
    public $timestamps = false;
    protected $primaryKey = 'id_capacidad';
    public $incrementing = true;
    protected $fillable = array('tipo');
}
