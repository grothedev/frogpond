<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['ip', 'reason', 'croak_id'];

    public function Croak(){
        return $this->belongsTo('App\Croak');
    }
}