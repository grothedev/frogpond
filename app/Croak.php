<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Croak extends Model
{
    protected $fillable = [
      'x', 'y', 'ip', 'type', 'content', 'fade_rate', 'file_id', 'p_id'
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function parent(){
      return $this->belongsTo('App\Croak');
    }

    public function tags(){
      return $this->belongsToMany('App\Tag');
    }

    public function files(){
      return $this->belongsToMany('App\File');
    }

    //comments

    //votes
}
