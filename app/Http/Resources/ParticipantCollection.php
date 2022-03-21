<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $grades = array();
        foreach ($this->resource as $matiere) {
        $grades[] = array(
            //'nom' =>$this->nom,
           // 'prenom' => $this->prenom,
            'matiere' => $matiere->nom_matiere,
            'niveau' => $matiere->id_niveau
        );
    }
        return $grades;
    }
}
