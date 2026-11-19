<?php
namespace App\Controllers;

use App\Models\Categorie;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des catégories
class CategorieController {
    
    // Tout ce contrôleur est réservé à l'administrateur
    public function __construct(){
        
        Auth::privilege(Auth::ADMIN);
    }
    // Liste des catégories avec le nombre de cours
    public function index($data = []){
        $categorie = new Categorie;
        $categories = $categorie->select('nom');

        // On ajoute le nombre de cours à chaque catégorie
        foreach($categories as $key => $cat){
            $categories[$key]['nb_cours'] = $categorie->compterCours($cat['idcategorie']);
        }

        $erreur = null;
        if(isset($data['erreur'])){
            $erreur = 'Impossible de supprimer cette catégorie : elle contient encore des cours.';
        }
        return View::render('categorie/index', ['categories' => $categories, 'erreur' => $erreur]);
    }

    public function create(){
        return View::render('categorie/create');
    }

    public function store(array $data){
        $val = $this->valider($data);

        if($val->isSuccess()){
            $categorie = new Categorie;
            $categorie->insert($data);
            return View::redirect('categories?message=ajoute');
        }else{
            return View::render('categorie/create', ['errors' => $val->getErrors(), 'categorie' => $data]);
        }
    }

    public function edit($data = []){
        if(isset($data['id'])){
            $categorie = new Categorie;
            $uneCategorie = $categorie->selectId($data['id']);
            if($uneCategorie){
                return View::render('categorie/edit', ['categorie' => $uneCategorie]);
            }
        }
        return View::render('error', ['msg' => 'Cette catégorie est introuvable.']);
    }

    public function update(array $data, $get = []){
        if(isset($get['id'])){
            $val = $this->valider($data);

            if($val->isSuccess()){
                $categorie = new Categorie;
                $categorie->update($data, $get['id']);
                return View::redirect('categories?message=modifie');
            }else{
                $data['idcategorie'] = $get['id'];
                return View::render('categorie/edit', ['errors' => $val->getErrors(), 'categorie' => $data]);
            }
        }
        return View::render('error', ['msg' => 'Cette catégorie est introuvable.']);
    }

    // Suppression refusée si la catégorie contient encore des cours (ON DELETE RESTRICT)
    public function delete($data){
        $categorie = new Categorie;
        if($categorie->compterCours($data['idcategorie']) > 0){
            return View::redirect('categories?erreur=cours');
        }
        $categorie->delete($data['idcategorie']);
        return View::redirect('categories?message=supprime');
    }

    // Règles de validation d'une catégorie
    private function valider($data){
        $val = new Validator;
        $val->field('nom', $data['nom'] ?? '', 'Le nom')->required()->min(2)->max(80);
        $val->field('description', $data['description'] ?? '', 'La description')->max(255);
        return $val;
    }
}