<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Croak extends Model
{
    use HasFactory;

    protected $fillable = [
        'x', 'y', 'ip', 'type', 'content', 'fade_rate', 'file_id', 'p_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function parent(){
        return $this->belongsTo('App\Models\Croak');
    }

    public function comments(){
        $result = [];
        foreach (Croak::all() as $c){
           if ($c['p_id'] == $this->id){
                array_push($result, $c);
           }
        }
        return $result;
        //return $this->hasMany('App\Models\Croak');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }

    public function files(){
        return $this->belongsToMany('App\Models\File');
    }

    public function votes(){
        return $this->hasMany('App\Models\Vote');
    }
}
