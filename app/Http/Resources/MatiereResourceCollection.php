<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MatiereResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $matiere =$request;
        if(empty($matiere)){
            $matiere = [
                'status' => '405',
                'commentaire' => 'il n y a aucune matiere'
            ];
            return ($matiere);
        }
        $grades = array();
        foreach ($this->resource as $matiere) {
        $grades[] = array(
            'matiere' => $matiere->nom_matiere,
            'niveau' => $matiere->niveau->niveau
        );
    }
    return $grades;
    }
}
