<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = "owners";
    protected $fillable = ['name', 'email', 'password'];
    protected $primaryKey = 'owner_id';
}

