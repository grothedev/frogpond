<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'v', 'croak_id'];

    public function croak(){
        return $this->belongsTo('App\Models\Croak');
    }
}
