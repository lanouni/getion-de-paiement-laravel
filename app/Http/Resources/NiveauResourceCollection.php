<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NiveauResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $niveau = parent::toArray($request);
        if(empty($niveau)){
            $niveau = [
                'status' => '405',
                'commentaire' => 'il n y a aucun niveau'
            ];
            return ($niveau);
        }
        return $niveau;
    }
}
