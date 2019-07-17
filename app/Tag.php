<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['label'];

    public function croaks(){
      return $this->belongsToMany('App\Croak');
    }
}
