<?php
namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Inscription;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des étudiants
class EtudiantController {

// Tout ce contrôleur est réservé à l'administrateur
    public function __construct(){
        Auth::privilege(Auth::ADMIN);
    }

    // Liste des étudiants avec le nombre de cours suivis
    public function index(){
        $etudiant = new Etudiant;
        $etudiants = $etudiant->select('nom');

        foreach($etudiants as $key => $e){
            $etudiants[$key]['nb_cours'] = $etudiant->compterCours($e['idetudiant']);
        }
        return View::render('etudiant/index', ['etudiants' => $etudiants]);
    }

    // Fiche d'un étudiant avec ses cours suivis (relation N-N)
    public function show($data = []){
        if(isset($data['id'])){
            $etudiant = new Etudiant;
            $unEtudiant = $etudiant->selectId($data['id']);
            if($unEtudiant){
                $inscription = new Inscription;
                $coursSuivis = $inscription->selectByEtudiant($data['id']);
                return View::render('etudiant/show', ['etudiant' => $unEtudiant, 'coursSuivis' => $coursSuivis]);
            }
        }
        return View::render('error', ['msg' => 'Cet étudiant est introuvable.']);
    }

    public function create(){
        return View::render('etudiant/create');
    }

    public function store(array $data){
        $val = $this->valider($data);

        if($val->isSuccess()){
            $etudiant = new Etudiant;
            $insert = $etudiant->insert($data);
            return View::redirect('etudiant/show?id='.$insert.'&message=ajoute');
        }else{
            return View::render('etudiant/create', ['errors' => $val->getErrors(), 'etudiant' => $data]);
        }
    }

    public function edit($data = []){
        if(isset($data['id'])){
            $etudiant = new Etudiant;
            $unEtudiant = $etudiant->selectId($data['id']);
            if($unEtudiant){
                return View::render('etudiant/edit', ['etudiant' => $unEtudiant]);
            }
        }
        return View::render('error', ['msg' => 'Cet étudiant est introuvable.']);
    }

    public function update(array $data, $get = []){
        if(isset($get['id'])){
            $val = $this->valider($data);

            if($val->isSuccess()){
                $etudiant = new Etudiant;
                $etudiant->update($data, $get['id']);
                return View::redirect('etudiant/show?id='.$get['id'].'&message=modifie');
            }else{
                $data['idetudiant'] = $get['id'];
                return View::render('etudiant/edit', ['errors' => $val->getErrors(), 'etudiant' => $data]);
            }
        }
        return View::render('error', ['msg' => 'Cet étudiant est introuvable.']);
    }

    // Suppression (ses inscriptions sont supprimées par ON DELETE CASCADE)
    public function delete($data){
        $etudiant = new Etudiant;
        $etudiant->delete($data['idetudiant']);
        return View::redirect('etudiants?message=supprime');
    }

    // Règles de validation d'un étudiant
    private function valider($data){
        $val = new Validator;
        $val->field('prenom', $data['prenom'] ?? '', 'Le prénom')->required()->min(2)->max(60);
        $val->field('nom', $data['nom'] ?? '', 'Le nom')->required()->min(2)->max(60);
        $val->field('email', $data['email'] ?? '', 'Le courriel')->required()->max(120)->email();
        return $val;
    }
}