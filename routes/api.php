<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Etudiant;
use App\Http\Middleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//   Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::apiResource('etudiant','EtudiantController');

//Route::apiResource("etudiant","EtudiantController");

Route::group(
    ['Middleware' => 'api'], 
    
    function () {
        Route::get("etudiant/{etudiant}/{prenom}","EtudiantController@show")->name("etudiant.show");
        Route::get("etudiant","EtudiantController@index")->name("etudiant.index");
        Route::post("etudiant","EtudiantController@store")->name("etudiant.store");
        Route::delete("etudiant/d","EtudiantController@destroy")->name("etudiant.destroy");
        Route::delete("etudiant/all","EtudiantController@destroyAll")->name("etudiant.destroyAll");
        Route::put('etudiant/{id}/{prenom}', "EtudiantController@update")->name("etudiant.update");

        Route::get("matiere/{matiere}","MatiereController@show")->name("matiere.show");
        Route::get("matiere_prec/{matiere}","MatiereController@get")->name("matiere.get");
        Route::get("matiere","MatiereController@index")->name("matiere.index");
        Route::post("matiere","MatiereController@store")->name("matiere.store");
        Route::delete("matiere/d/{id}","MatiereController@destroy")->name("matiere.destroy");
        Route::delete("matiere/all","MatiereController@destroyAll")->name("matiere.destroyAll");
        Route::put('matiere/{id}', "MatiereController@update")->name("matiere.update");

        Route::get('{niveau}/matiere', "NiveauController@affiche");

        Route::get("niveau/{niveau}","NiveauController@show")->name("niveau.show");
        Route::get("niveau","NiveauController@index")->name("niveau.index");
        Route::post("niveau","NiveauController@store")->name("niveau.store");
        Route::delete("niveau/d","NiveauController@destroy")->name("niveau.destroy");
        Route::delete("niveau/all","NiveauController@destroyAll")->name("niveau.destroyAll");
        Route::put('niveau/{id}', "NiveauController@update")->name("niveau.update");

        Route::get('etudiantMatiere/{matiere}',"ParticipantController@show");
        Route::get('etudiantNiveau/{matiere}',"ParticipantController@EtudiantNiveau");
        Route::get('etudiant/matiere/details/{nom}/{prenom}',"ParticipantController@Etudiant");
        Route::post('etudiantMatiere',"ParticipantController@store");
        Route::post('etudiantMatiere/add',"ParticipantController@store2");
        Route::put('etudiantMatiere/{matiere}', "ParticipantController@update");
        Route::delete('participer/{nom}/{prenom}/{matiere}',"ParticipantController@destroy");

        Route::get('etudiant/matiere/{niveau}/{matiere}','EtudiantController@Niveau');
        Route::get('etudiant/matiere/{nom}/{niveau}/{matiere}','EtudiantController@Prenom');

        Route::get('historique/{nom}/{prenom}/{niveau}/{matiere}','DetailController@show');
        Route::get('historique/all','DetailController@index')->name('details.index');
        Route::post('historique','DetailController@store');
        Route::delete('historique/{nom}/{prenom}/{niveau}/{matiere}/{mois}','DetailController@destroy')->name('details.index');       
});