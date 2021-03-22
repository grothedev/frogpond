<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'path', 'filesize'];

	public function upload(){

        $dst = 'f'; //keepin it simple

		$f = file($this->filename);

        return $f->move($dst, $this->filename);
	}

    public function croak(){
      return $this->belongsToMany('App\Models\Croak');
    }
}
