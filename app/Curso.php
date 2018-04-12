<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use SoftDeletes;

    protected $table = 'cursos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'universidad_id', 'slug'
    ];


    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function universidad()
    {
        return $this->belongsTo('App\Universidad');
    }
}
