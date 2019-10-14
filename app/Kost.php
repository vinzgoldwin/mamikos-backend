<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $table = "kosts";
    protected $fillable = ['kost_name', 'avail_room_count', 'address','description','city','price'];
    protected $primaryKey = 'kost_id';
}
