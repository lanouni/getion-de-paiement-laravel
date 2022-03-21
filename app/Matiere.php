<?php

namespace App;
use App\Niveau;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'Matieres';
    protected $primaryKey = "id_matiere";
    protected $fillable = [
        'nom_matiere',
        'prix',
        'id_niveau',
    ];
    public $timestamps = false;
  public function niveau()
  {
      return $this->belongsTo(Niveau::class, 'id_niveau');
  }
  public function etudiant(){
      return $this->brlongsToMany(App/Etudiant::class , "id");
  }

}
