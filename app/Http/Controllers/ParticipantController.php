<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Resources\ParticipantCollection;
use App\Etudiant;
use App\Http\Resources\EtudiantResource;
use App\Participer;
use App\Matiere;


class ParticipantController extends Controller
{
    // public function index(){
    //     return new ParticipantCollection(DB::select('select nom , prenom,ville,nom_matiere from etudiants e , matieres m , 
    //     participers p where e.id = p.id and m.id_matiere = p.id_matiere and nom_matiere = ?'));
    // }
    public function show($matiere){
        $data = DB::select('select nom , prenom,ville,phone_1 ,phone_2,date_insc, nom_matiere as matiere from etudiants e , matieres m , 
        participers p where e.id = p.id and m.id_matiere = p.id_matiere and nom_matiere = ?',[$matiere]);
        if($data == null){
            return [
                'commentaire' => 'emty'
            ];
        }
        return ($data);
    }
    public function Etudiant($nom , $prenom ){
        $data = DB::table('participers')
                    ->join('matieres','matieres.id_matiere','=','participers.id_matiere')
                    ->join('etudiants','etudiants.id','=','participers.id')
                    ->where('nom','=',$nom)
                    ->where('prenom','=',$prenom)
                    ->get();

        return $data;
        if($data == null){
            return [
                'commentaire' => 'emty'
            ];
        }
        return ($data);
    }
    public function EtudiantNiveau($niveau){
        // $data = DB::table('participers')
        //             ->join('matieres','matieres.id_matiere','=','participers.id_matiere')
        //             ->join('etudiants','etudiants.id','=','participers.id')
        //             ->join('niveaux','niveaux.id_niveau','=','matieres.id_niveau')
        //             ->where('niveau','=',$niveau)
        //             ->get();
        $data = DB::select('select * from participers p , etudiants e , niveaux n , matieres m where 
                            m.id_niveau = n.id_niveau and 
                            p.id = e.id and 
                            m.id_matiere = p.id_matiere and 
                            niveau = ? ',[$niveau]);

        return $data;
        if($data == null){
            return [
                'commentaire' => 'emty'
            ];
        }
        return ($data);
    }

    public function rechercher(Request $request){
        
                   
            DB::insert('insert into etudiants (nom,prenom,ville,phone_1,phone_2,date_insc) 
                        values (?, ?,?,?,?,?)', 
                        [$request['nom'],$request['prenom'],$request['ville'],$request['phone_1'],$request['phone_2'],$request['date_insc']]);
            $etudiant = Etudiant::select("id")->where('nom','=',$request['nom'])
                                        ->Where('prenom','=',$request['prenom'])
                                        ->get();    
        
            foreach($etudiant as $data){
                   $matieres = DB::table('niveaux')
                                    ->join('matieres','matieres.id_niveau','=','niveaux.id_niveau')
                                    ->where("nom_matiere","=",$request['nom_matiere'])
                                    ->where("niveau","=",$request['niveau'])
                                    ->get();
                            //return $matieres;
                 if(empty($matieres) ){
                    return 0;
                }
               
                foreach ($matieres as $key ) {
                    $participant = Participer::where("id",'=',$data['id'])
                                            ->where("id_matiere" ,'=',$key->id_matiere)
                                            ->get();
                    if((json_decode($participant) != null )){
                        return -2;
                        
                    }
                    else DB::insert("insert into participers (id, id_matiere) values (?, ?)", [$data['id'],$key->id_matiere]); 
                     
                }
               
            }
            if(json_decode($etudiant) == null){     
            return -1;
        }
       return 1;
    }

    public function store(Request $request){
        $validation = $request->validateWithBag("post",[
            'nom' => 'required|min:3|alpha',
            'prenom' => 'required|min:3|alpha',
            'ville' => 'required|min:2|max:60|alpha',
            'phone_1' => 'required|numeric|min:9',
            'phone_2' => 'numeric|min:9',
            'date_insc'=>'date',
            'nom_matiere' => "required|min:2|",
            'niveau'=>'required|min:2'
        ]);
            $recherche = $this->rechercher($request);
            if($recherche == 0){
                return [
                    'commentaire'=>"matiere n'existe pas",
                ];
            }
            elseif($recherche == -1 ){
                return[
                    'commentaire' => "etudiant n'existe pas"
                ];
            }
            elseif($recherche == -2){
                return [
                    'commentaire'=>'etudiant deja inscrit dans cette matiere'
                ];
            }
            else{
              return "etudiant".$request['nom']." inscrit dans".$request["nom_matiere"];  
            }
    }

    public function rechercher2(Request $request){
        
        $etudiant = Etudiant::select("id")->where('nom','=',$request['nom'])
                                    ->Where('prenom','=',$request['prenom'])
                                    ->get();    
    
        foreach($etudiant as $data){
               $matieres = DB::table('niveaux')
                                ->join('matieres','matieres.id_niveau','=','niveaux.id_niveau')
                                ->where("nom_matiere","=",$request['nom_matiere'])
                                ->where("niveau","=",$request['niveau'])
                                ->get();
                        //return $matieres;
             if(empty($matieres) ){
                return 0;
            }
           
            foreach ($matieres as $key ) {
                $participant = Participer::where("id",'=',$data['id'])
                                        ->where("id_matiere" ,'=',$key->id_matiere)
                                        ->get();
                if((json_decode($participant) != null )){
                    return -2;
                    
                }
                else DB::insert("insert into participers (id, id_matiere) values (?, ?)", [$data['id'],$key->id_matiere]); 
                 
            }
           
        }
        if(json_decode($etudiant) == null){     
        return -1;
    }
   return 1;
}

public function store2(Request $request){
    $validation = $request->validateWithBag("post",[
        'nom' => 'required|min:3|alpha',
        'prenom' => 'required|min:3|alpha',
        'nom_matiere' => "required|min:2|",
        'niveau'=>'required|min:2'
    ]);
        $recherche = $this->rechercher2($request);
        if($recherche == 0){
            return [
                'commentaire'=>"matiere n'existe pas",
            ];
        }
        elseif($recherche == -1 ){
            return[
                'commentaire' => "etudiant n'existe pas"
            ];
        }
        elseif($recherche == -2){
            return [
                'commentaire'=>'etudiant deja inscrit dans cette matiere'
            ];
        }
        else{
          return "etudiant".$request['nom']." inscrit dans".$request["nom_matiere"];  
        }
}


    protected function rec($mat , $nom , $prenom , $matiere,$niveau){
        $etudiant = Etudiant::where('nom','=',$nom)
                            ->where('prenom','=',$prenom)
                            ->get();

        $matieres = DB::table('niveaux')
                            ->join('matieres','matieres.id_niveau','=','niveaux.id_niveau')
                            ->where("nom_matiere","=",$matiere)
                            ->where("niveau","=",$niveau)
                            ->get();

        $prec = Matiere::where('nom_matiere','=',$mat)->get();  

                            if(count($prec->toArray())>1){
                                return ['commentaire '=>"existe plusieur matiere avec ce nom"];
                            }

                            if(json_decode($etudiant) == null){
                                return ['commentaire'=>"il n y a aucun etudiant avec ce nom "];
                            }
                            if(json_decode($matieres)==null){
                                return ['commentaire '=>'il n y a aucune matiere avec ce nom'];
                            }
                          
                            foreach($etudiant as $data){
                                foreach($matieres as $key){
                                    foreach($prec as $find){
                                        $update = Participer::where([
                                            ['id','=',$data['id']],
                                            ['id_matiere','=',$prec['id_matiere']]
                                        ])->update(['id'=>$data['key'],'id_matiere'=>$key->id_matiere]);
                                    }
                                }
                            }
         return $update;
       
    }

    public function update ($matiere , Request $request){
        $validation = $request->validateWithBag("post",[
            'nom' => 'min:3|alpha',
            'prenom' => 'min:3|alpha',
            'matiere' => "min:2|",
            'niveau'=>'min:2'
        ]); 
       return $this->rec($matiere,$request['nom'],$request['prenom'],$request['matiere'],$request['niveau']);
    }

    public function destroy($nom ,$prenom , $matiere){
         DB::table('participers')
                ->join('matieres','matieres.id_matiere','=','participers.id_matiere')
                ->join('etudiants','etudiants.id','=','participers.id')
                ->where('nom','=',$nom)
                ->where('prenom','=',$prenom)
                ->where('nom_matiere','=',$matiere)
                ->delete();
        return true;
    }
}
