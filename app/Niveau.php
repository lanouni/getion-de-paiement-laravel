<?php

namespace App;
use App\Matiere;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $primaryKey = "id_niveau";
    protected $fillable =[
        "niveau"
    ];
    public $timestamps = false;
    public function matieres(){
        return $this->hasMany(Matiere::class,'id_niveau');
    }

}
