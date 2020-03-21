<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    protected $fillable = ['idPost', 'idUser'];
    public $timestamps = false;
}
