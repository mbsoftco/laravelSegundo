<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Apunte extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'user_id', 'curso_id', 'slug', 'tipo', 'ciclo', 'universidad_id', 'docente', 'archivos', 'descripcion', 'comentarios', 'positivos', 'negativos', 'thumbnail'
    ];

    public function archivos()
    {
        return $this->hasMany('App\Archivo');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function curso()
    {
        return $this->belongsTo('App\Curso');
    }

    public function comentarios()
    {
        return $this->hasMany('App\ApunteComentario');
    }

    public function reacciones()
    {
        return $this->hasMany('App\ApunteReaccion');
    }
}
