<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['filename', 'path', 'filesize'];

    public function croak(){
      return $this->belongsToMany('App\Croak');
    }
}
