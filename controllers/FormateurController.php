<?php
namespace App\Controllers;

use App\Models\Formateur;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des formateurs
class FormateurController {
       // Tout ce contrôleur est réservé à l'administrateur
    public function __construct(){
        Auth::privilege(Auth::ADMIN);
    }
    // Liste des formateurs avec le nombre de cours donnés
    public function index($data = []){
        $formateur = new Formateur;
        $formateurs = $formateur->select('nom');

        foreach($formateurs as $key => $f){
            $formateurs[$key]['nb_cours'] = $formateur->compterCours($f['idformateur']);
        }

        $erreur = null;
        if(isset($data['erreur'])){
            $erreur = 'Impossible de supprimer ce formateur : il donne encore des cours.';
        }
        return View::render('formateur/index', ['formateurs' => $formateurs, 'erreur' => $erreur]);
    }

    public function create(){
        return View::render('formateur/create');
    }

    public function store(array $data){
        $val = $this->valider($data);

        if($val->isSuccess()){
            $formateur = new Formateur;
            $formateur->insert($data);
            return View::redirect('formateurs?message=ajoute');
        }else{
            return View::render('formateur/create', ['errors' => $val->getErrors(), 'formateur' => $data]);
        }
    }

    public function edit($data = []){
        if(isset($data['id'])){
            $formateur = new Formateur;
            $unFormateur = $formateur->selectId($data['id']);
            if($unFormateur){
                return View::render('formateur/edit', ['formateur' => $unFormateur]);
            }
        }
        return View::render('error', ['msg' => 'Ce formateur est introuvable.']);
    }

    public function update(array $data, $get = []){
        if(isset($get['id'])){
            $val = $this->valider($data);

            if($val->isSuccess()){
                $formateur = new Formateur;
                $formateur->update($data, $get['id']);
                return View::redirect('formateurs?message=modifie');
            }else{
                $data['idformateur'] = $get['id'];
                return View::render('formateur/edit', ['errors' => $val->getErrors(), 'formateur' => $data]);
            }
        }
        return View::render('error', ['msg' => 'Ce formateur est introuvable.']);
    }

    // Suppression refusée si le formateur donne encore des cours (ON DELETE RESTRICT)
    public function delete($data){
        $formateur = new Formateur;
        if($formateur->compterCours($data['idformateur']) > 0){
            return View::redirect('formateurs?erreur=cours');
        }
        $formateur->delete($data['idformateur']);
        return View::redirect('formateurs?message=supprime');
    }

    // Règles de validation d'un formateur
    private function valider($data){
        $val = new Validator;
        $val->field('prenom', $data['prenom'] ?? '', 'Le prénom')->required()->min(2)->max(45);
        $val->field('nom', $data['nom'] ?? '', 'Le nom')->required()->min(2)->max(100);
        $val->field('email', $data['email'] ?? '', 'Le courriel')->required()->max(120)->email();
        $val->field('specialite', $data['specialite'] ?? '', 'La spécialité')->required()->max(100);
        $val->field('biographie', $data['biographie'] ?? '', 'La biographie')->max(2000);
        return $val;
    }
}