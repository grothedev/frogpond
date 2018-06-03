<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Croak extends Model
{
    protected $fillable = [
      'x', 'y', 'ip', 'type', 'content', 'fade_rate'
    ];
}
