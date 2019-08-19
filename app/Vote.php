<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['ip', 'v', 'croak_id'];

    public function Croak(){
        return $this->belongsTo('App\Croak');
    }
}
