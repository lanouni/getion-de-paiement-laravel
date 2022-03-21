<?php

namespace App\Http\Controllers;

use App\Http\Resources\NiveauResource;
use App\Http\Resources\NiveauResourceCollection;
use App\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    public function affiche( Niveau $Niveau){
        return $Niveau;
    }

    public function show( $id)
    {
        $Niveau = Niveau::where('niveau',$id)
                            ->get();
        if(json_decode($Niveau) == null){
             return new NiveauResource(["status"=>"555","commentaire"=>"n'existe aucun niveau"]);
        }
       return new NiveauResource($Niveau);
    }

    public function index()
    {
         return (Niveau::all() );
    }

    protected function recherche($id){
        $Niveau = Niveau::where('niveau','=',$id)->get();
        if(json_decode($Niveau) == null){
             return null;
        }
       return new NiveauResource($Niveau);
    }



    
    public function store(Request $request)
    {
        $validation= $request->validateWithBag('post',[
            'niveau' => 'required|min:2|max:60',
        ]); 
        $recherche =$this->recherche($request["niveau"]);
        if($recherche != null){
            return response()->json("Niveau existe deja");
        }
      $Niveau =  Niveau::create($request->all());

        return new NiveauResource ($Niveau);
    }

  
  
  
  
  
  
    public function update( $id,Request $request)
    {
        $Niveau= Niveau::where('niveau','=',$id)->get();
        if(json_decode($Niveau) == null){
            return response()->json("aucun Niveau existe");
        }
        if(count($Niveau->toArray())>1){
            return response()->json("existe plusieurs");
        }
        $update= Niveau::where('niveau','=',$id)->update($request->all());
        return response()->json("Niveau a ete modifier correctement");
    }










    public function destroy(Request $request)
    {       $Niveau = $this->recherche($request["niveau"]);
        if($Niveau == null){
            return response()->json("Niveau n'existe pas");
        }
        if(count($Niveau->toArray($Niveau))> 1){
            return response()->json("existe plusieurs");
        }
        $Niveau = Niveau::where('niveau','=',$request['niveau'])->delete();
            return new NiveauResource([
                'status ' => "200",
                'commentaire ' =>"l'Niveau a ete supprimmer correctement"
            ]);
    }
}
