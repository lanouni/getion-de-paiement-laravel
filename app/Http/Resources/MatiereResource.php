<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatiereResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
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
