<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ApunteComentario extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'apunte_id', 'texto', 'positivos', 'negativos'
    ];

    public function apunte()
    {
        return $this->belongsTo('App\Apunte');
    }

    public function reacciones()
    {
        return $this->hasMany('App\ApunteComentarioReaccion');
    }

}
