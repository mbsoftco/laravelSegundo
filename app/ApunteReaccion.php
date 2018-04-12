<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApunteReaccion extends Model
{
    protected $table = 'apunte_reacciones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'apunte_id', 'tipo'
    ];

    public function apunteComentario()
    {
        return $this->belongsTo('App\Apunte');
    }
}
