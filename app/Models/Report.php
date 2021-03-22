<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'reason', 'croak_id'];

    public function Croak(){
        return $this->belongsTo('App\Models\Croak');
    }
}
