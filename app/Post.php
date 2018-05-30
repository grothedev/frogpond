<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
      'x', 'y', 'type', 'ip', 'alpha_rate'
    ]
}
