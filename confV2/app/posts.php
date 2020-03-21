<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    protected $fillable = ['idUser','idCategory','post'];
}
