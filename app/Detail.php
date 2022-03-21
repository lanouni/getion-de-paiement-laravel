<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        "id",
        "id_matiere",
        "id_HP",
        "mtn"
    ];
}
