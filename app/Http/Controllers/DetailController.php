<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DetailController extends Controller
{
    public function index(){
        $all = DB::select('select * from etudiants e , details d , paiements p , matieres m where 
                                m.id_matiere = d.id_matiere and
                                p.id_paiement = d.id_paiement and 
                                e.id = p.id
        ');
        if($all  == null ){
            return [
                'error'=>"aucun etudiant n'a paye"
            ];
        }
        return $all;
    }

    public function show($nom , $prenom ,$niveau, $matiere ){
        $all = DB::select('select * from etudiants e , details d , paiements p , matieres m , niveaux n where 
                                m.id_matiere = d.id_matiere and
                                p.id_paiement = d.id_paiement and 
                                m.id_niveau = n.id_niveau and
                                e.id = p.id and
                                nom = ? and 
                                prenom = ? and 
                                nom_matiere = ? and 
                                niveau = ? 
        ',[$nom , $prenom , $matiere , $niveau]);
        if($all  == null ){
            return [
                'error'=>"etudiant n'a pas encore paye"
            ];
        }
        return $all;
    }

    public function destroy($nom , $prenom ,$niveau, $matiere , $mois){
        $select = DB::select('select * from etudiants e , details d , paiements p , matieres m , niveaux n where 
                            m.id_matiere = d.id_matiere and
                            p.id_paiement = d.id_paiement and 
                            m.id_niveau = n.id_niveau and
                            e.id = p.id and
                            nom = ? and 
                            prenom = ? and 
                            nom_matiere = ? and 
                            niveau = ? and 
                           MONTH(date_p)= ?
                    ',[$nom , $prenom , $matiere , $niveau ,$mois ]);
        if($select  == null ){
            return [
                 'error'=>"aucun etudiant n'a paye"
            ];
        }
      
        foreach($select as $data){
            DB::delete('delete from paiements where id_paiement = ?', [$data->id_paiement]);
            return DB::delete('delete from Details where id_paiement = ?', [$data->id_paiement]);
        }
            return null;
    }

    public function store(Request $request){
        $validation= $request->validateWithBag('post',[
            'nom' => 'required|min:2|max:60|alpha',
            'prenom' => 'required|min:2|max:60|alpha',
            'nom_matiere'=>'required|min:2',
            'niveau'=>'required|min:2',
            'mois'=>'',
            'date'=>'date'
        ]); 
        $select = DB::select('select * from etudiants e , details d , paiements p , matieres m , niveaux n where 
                    m.id_matiere = d.id_matiere and
                    p.id_paiement = d.id_paiement and 
                    m.id_niveau = n.id_niveau and
                    e.id = p.id and
                    nom = ? and 
                    prenom = ? and 
                    nom_matiere = ? and 
                    niveau = ? and 
                MONTH(date_p)= ?
            ',[$request['nom'] , $request['prenom'] , $request['nom_matiere'] , $request['niveau'] ,$request['mois'] ]);
            
        if($select  != null ){
                return [
                'error'=>"aucun etudiant n'a paye"
                ];
        }
        $select1 = DB::select('select * from etudiants e , details d , paiements p , matieres m , niveaux n where 
        m.id_matiere = d.id_matiere and
        p.id_paiement = d.id_paiement and 
        m.id_niveau = n.id_niveau and
        e.id = p.id and
        nom = ? and 
        prenom = ? and 
        nom_matiere = ? and 
        niveau = ?  
        ',[$request['nom'] , $request['prenom'] , $request['nom_matiere'] , $request['niveau'] ]);
       
        foreach ($select1 as $key) {
            DB::insert('insert into paiements (id) values (?)', [$key->id]);
            DB::insert('insert into details (id_paiement,id_matiere,date_p ) values (?,?,?)',[$key->id_paiement , $key->id_matiere,$request["date_p"]]);
        }
        return [
            'success'=>'felicitation'
        ];
    }
}
