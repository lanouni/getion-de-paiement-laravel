<?php

namespace App\Http\Controllers;

use App\Http\Resources\MatiereResource;
use App\Http\Resources\MatiereResourceCollection;
use App\Matiere;
use Illuminate\Http\Request;
use DB;
use App\Niveau;

class MatiereController extends Controller
{
    public function get( $id)
    {
        $Matiere = DB::select('select * from matieres e , niveaux n where e.id_niveau = n.id_niveau and nom_matiere = ?',[$id]);
        if(($Matiere) == null){
             return (["status"=>"555",
             "commentaire" => "n'existe pas"]);
        }
       return ($Matiere);
    }
    public function show( $id)
    {
        $Matiere = DB::select('select * from matieres e , niveaux n where e.id_niveau = n.id_niveau and niveau = ?',[$id]);
        if(($Matiere) == null){
             return (["status"=>"555",
             "commentaire" => "n'existe pas"]);
        }
       return ($Matiere);
    }

    public function index()
    {   
        $Matiere = DB::select('select * from matieres e , niveaux n where e.id_niveau = n.id_niveau');
         return ($Matiere );
    }

    protected function recherche($matiere ,$prix, $niveau){
        $matieres = DB::table('niveaux')
                         ->join('matieres','matieres.id_niveau','=','niveaux.id_niveau')
                         ->where("nom_matiere","=",$matiere)
                         ->where("niveau","=",$niveau)
                         ->get();
                        
        if(!empty(json_decode($matieres)) ){
             return null;
        }
        $niveaux =Niveau::where('niveau','=',$niveau)->get();
        foreach($niveaux as $data){
               $Matiere =  DB::insert('insert into matieres (nom_matiere, prix , id_niveau) values (?, ?,?)',
                         [ $matiere , $prix ,$data['id_niveau']]);
        }
     

         return true;
    }



    
    public function store(Request $request)
    {
        $validation= $request->validateWithBag('post',[
            'nom_matiere' => 'required|min:2',
            'prix' => 'required|min:2|numeric',
            'niveau'=>'required'
        ]); 
        $recherche =$this->recherche($request["nom_matiere"],$request['prix'],$request['niveau']);
        if($recherche == null){
            return response()->json("Matiere existe deja");
        } 

        return [
            'commentaire'=>'matiere ajouter'
        ];

    }

  
  
  
  
  
  
    public function update( $id,Request $request)
    {
        $Matiere= Matiere::where('nom_matiere','=',$id)->get();
        if(($Matiere) == null){
            return response()->json("aucune Matiere existe");
        }
        if(count($Matiere->toArray())>1){
            return response()->json("existe plusieurs");
        }
        $update= Matiere::where('nom_matiere','=',$id)->update($request->all());
        return response()->json("Matiere a ete modifier correctement");
    }










    public function destroy($id)
    {   
        $Matiere = Matiere::where('nom_matiere','=',$id)
                    ->delete();
            return ([
                'status ' => "200",
                'commentaire ' =>"l'Matiere a ete supprimmer correctement"
            ]);
}
}
