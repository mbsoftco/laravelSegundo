<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ApunteComentarioReaccion extends Model
{
    protected $table = 'apunte_comentario_reacciones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'apunte_comentario_id', 'tipo'
    ];

    public function apunteComentario()
    {
        return $this->belongsTo('App\ApunteComentario');
    }
}
