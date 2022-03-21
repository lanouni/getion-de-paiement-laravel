<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Matiere;

class Etudiant extends Model
{
    protected $primaryKey = "id";
    protected $fillable =[
        'nom',
        'prenom',
        'ville',
        'phone_1',
        'phone_2',
        'date_insc'    
    ];
    public $timestamps = false;

    public function matiere(){
        return $this->belongsToMany(Matiere::class , "id_matiere");
    }
}
