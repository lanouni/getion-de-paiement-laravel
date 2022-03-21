<?php

namespace App\Http\Controllers;

use App\Etudiant;
use Illuminate\Http\Request;
use App\Http\Resources\EtudiantResource;
use App\Http\Resources\EtudiantResourceCollection;
use DB;

class EtudiantController extends Controller
{

    public function show( $nom , $prenom)
    {
        $etudiant = Etudiant::where('nom',$nom)
                            ->where('prenom',$prenom)
                            ->get();
        if(json_decode($etudiant) == null){
             return (["status"=>"555"]);
        }
       return ($etudiant);
    }

    /*public function index(): EtudiantResourceCollection
    {
         return new EtudiantResourceCollection(Etudiant::all() );
    }*/
    public function index(){
        return (DB::select('select nom , prenom,ville,phone_1,phone_2,date_insc from etudiants '));
    }

    protected function recherche($id,$prenom){
        $etudiant = Etudiant::where('nom','=',$id)
                            ->Where('prenom','=',$prenom)
                            ->get();
        if(json_decode($etudiant) == null){
             return null;
        }
       return new EtudiantResource($etudiant);
    }

    public function Niveau($niveau , $matiere){
       return DB::select('select * from etudiants e , matieres m , niveaux n , participers p
                    where e.id = p.id and 
                           p.id_matiere = m.id_matiere and
                           n.id_niveau = m.id_niveau and
                           niveau = ? and 
                           nom_matiere = ?  ',[$niveau,$matiere]);
    }
    public function Prenom($nom,$niveau , $matiere){
        return DB::select('select * from etudiants e , matieres m , niveaux n , participers p
                     where e.id = p.id and 
                            p.id_matiere = m.id_matiere and
                            n.id_niveau = m.id_niveau and
                            niveau = ? and 
                            nom_matiere = ? and
                            nom = ? ',[$niveau,$matiere,$nom]);
     }

    
    public function store(Request $request)
    {
        $validation= $request->validateWithBag('post',[
            'nom' => 'required|min:2|max:60|alpha',
            'prenom' => 'required|min:2|max:60|alpha',
            'ville' => 'required|min:2|max:60|alpha',
            'phone_1' => 'required|numeric|min:9',
            'phone_2' => 'numeric|min:9',
            'date_insc'=>'date'
        ]); 
        $recherche =$this->recherche($request["nom"],$request["prenom"]);
        if($recherche != null){
            return response()->json("etudiant existe deja");
        }
      $etudiant =  Etudiant::create($request->all());

        return new EtudiantResource ($etudiant);
    }

  
  
  
  
  
  
    public function update( $id,$prenom,Request $request)
    {
        $etudiant= Etudiant::where('nom','=',$id)
                            ->where('prenom','=',$prenom)
        ->get();
        if(json_decode($etudiant) == null){
            return response()->json("aucun etudiant existe");
        }
        if(count($etudiant->toArray())>1){
            return response()->json("existe plusieurs");
        }
        $update= Etudiant::where('nom','=',$id)->where('prenom','=',$prenom)->update($request->all());
        return response()->json("etudiant a ete modifier correctement");
    }










    public function destroy(Request $request)
    {       $etudiant = $this->recherche($request["nom"],$request["prenom"]);
        if($etudiant == null){
            return response()->json("etudiant n'existe pas");
        }
        if(count($etudiant->toArray($etudiant))> 1){
            return response()->json("existe plusieurs");
        }
        $etudiant = Etudiant::where('nom','=',$request['nom']) 
                               ->where('prenom','=',$request['prenom'])->delete();
            return new EtudiantResource([
                'status ' => "200",
                'commentaire ' =>"l'etudiant a ete supprimmer correctement"
            ]);
    }
}
