<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Croak extends Model
{
    protected $fillable = [
      'x', 'y', 'ip', 'type', 'content', 'fade_rate', 'file_id'
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }

    public function tags(){
      return $this->belongsToMany('App\Tag');
    }

    //comments

    //votes
}
