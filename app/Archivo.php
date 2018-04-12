<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'nombre', 'apunte_id', 'tipo', 'orden', 'version_pdf'
    ];


    public function user()
    {
        return $this->belongsTo('App\Apunte');
    }

}
