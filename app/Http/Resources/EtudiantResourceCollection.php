<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EtudiantResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $etudiant = parent::toArray($request);
        if(empty($etudiant)){
            $etudiant = [
                'status' => '405',
                'commentaire' => 'il n y a aucun etudiant'
            ];
            return ($etudiant);
        }
        return $etudiant;
    }
}
