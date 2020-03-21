<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class views extends Model
{
    protected $fillable = ['idPost','idUser'];
    public $timestamps = false;
}
