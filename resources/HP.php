<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HP extends Model
{
    protected $primaryKey = "id_HP";
    protected $fillable = [
       "date",
    ];
}
