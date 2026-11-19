<?php
namespace App\Controllers;

use App\Models\Cours;
use App\Models\Categorie;
use App\Models\Formateur;
use App\Models\Inscription;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des cours : CRUD complet de la table cours
// (table avec deux clés étrangères : categorie et formateur)
class CoursController {

    // Liste des cours (filtre possible : cours?categorie=2)
    public function index($data = []){
        $cours = new Cours;
        $categorie = new Categorie;
        $categories = $categorie->select('nom');

        $categorieChoisie = null;
        if(isset($data['categorie'])){
            $categorieChoisie = $data['categorie'];
        }
        $liste = $cours->selectDetails($categorieChoisie);

        return View::render('cours/index', ['listeCours' => $liste, 'categories' => $categories, 'categorieChoisie' => $categorieChoisie]);
    }

    // Détail d'un cours avec ses étudiants inscrits (relation N-N)
    public function show($data = []){
        if(isset($data['id'])){
            $cours = new Cours;
            $unCours = $cours->selectIdDetails($data['id']);
            if($unCours){
                $inscription = new Inscription;
                $inscrits = $inscription->selectByCours($data['id']);
                return View::render('cours/show', ['cours' => $unCours, 'inscrits' => $inscrits]);
            }else{
                return View::render('error', ['msg' => 'Ce cours est introuvable.']);
            }
        }else{
            return View::render('error', ['msg' => 'Code 404 - Page introuvable']);
        }
    }

    // Formulaire d'ajout
    public function create(){
        Auth::privilege(Auth::ADMIN);
        return View::render('cours/create', $this->listes());
    }

    // Enregistrement d'un nouveau cours
    public function store(array $data){
        Auth::privilege(Auth::ADMIN);
        $val = $this->valider($data);
        $extension = $this->verifierImage($val);

        if($val->isSuccess()){
            // L'image est déplacée seulement si tout le formulaire est valide
            if($extension){
                $data['image'] = $this->enregistrerImage($extension);
            }
            $cours = new Cours;
            $insert = $cours->insert($data);
            if($insert){
                return View::redirect('cours/show?id='.$insert.'&message=ajoute');
            }else{
                return View::render('error', ['msg' => "Le cours n'a pas pu être ajouté."]);
            }
        }else{
            $errors = $val->getErrors();
            return View::render('cours/create', array_merge($this->listes(), ['errors' => $errors, 'cours' => $data]));
        }
    }

    // Formulaire de modification
    public function edit($data = []){
        Auth::privilege(Auth::ADMIN);
        if(isset($data['id'])){
            $cours = new Cours;
            $unCours = $cours->selectId($data['id']);
            if($unCours){
                return View::render('cours/edit', array_merge($this->listes(), ['cours' => $unCours]));
            }
        }
        return View::render('error', ['msg' => 'Ce cours est introuvable.']);
    }

    // Enregistrement des modifications
    public function update(array $data, $get = []){
        Auth::privilege(Auth::ADMIN);
        if(isset($get['id'])){
            $val = $this->valider($data);
            $extension = $this->verifierImage($val);

            if($val->isSuccess()){
                $cours = new Cours;
                // Nouvelle image choisie : on supprime l'ancienne et on garde la nouvelle
                // Aucune image choisie : l'ancienne image reste en place
                if($extension){
                    $ancien = $cours->selectId($get['id']);
                    $this->supprimerImage($ancien['image']);
                    $data['image'] = $this->enregistrerImage($extension);
                }
                $update = $cours->update($data, $get['id']);
                if($update){
                    return View::redirect('cours/show?id='.$get['id'].'&message=modifie');
                }else{
                    return View::render('error', ['msg' => "Le cours n'a pas pu être modifié."]);
                }
            }else{
                $errors = $val->getErrors();
                $data['idcours'] = $get['id'];
                return View::render('cours/edit', array_merge($this->listes(), ['errors' => $errors, 'cours' => $data]));
            }
        }
        return View::render('error', ['msg' => 'Ce cours est introuvable.']);
    }

    // Suppression (les inscriptions du cours sont supprimées par ON DELETE CASCADE)
    public function delete($data){
        Auth::privilege(Auth::ADMIN);
        $cours = new Cours;
        $unCours = $cours->selectId($data['idcours']);
        $delete = $cours->delete($data['idcours']);
        if($delete){
            // On supprime aussi le fichier image du cours
            if($unCours){
                $this->supprimerImage($unCours['image']);
            }
            return View::redirect('cours?message=supprime');
        }else{
            return View::render('error', ['msg' => "Le cours n'a pas pu être supprimé."]);
        }
    }

    // ---------- Méthodes privées ----------

    // Règles de validation d'un cours (utilisées pour l'ajout et la modification)
    private function valider($data){
        $cours = new Cours;
        $val = new Validator;
        $val->field('titre', $data['titre'] ?? '', 'Le titre')->required()->min(3)->max(150);
        $val->field('description', $data['description'] ?? '', 'La description')->max(2000);
        $val->field('niveau', $data['niveau'] ?? '', 'Le niveau')->required()->in($cours->niveaux);
        $val->field('duree_heures', $data['duree_heures'] ?? '', 'La durée')->required()->int()->minValue(1)->maxValue(500);
        $val->field('prix', $data['prix'] ?? '', 'Le prix')->required()->number()->minValue(0)->maxValue(9999.99);
        $val->field('categorie_idcategorie', $data['categorie_idcategorie'] ?? '', 'La catégorie')->required()->int();
        $val->field('formateur_idformateur', $data['formateur_idformateur'] ?? '', 'Le formateur')->required()->int();

        // La catégorie et le formateur choisis doivent exister (clés étrangères)
        $categorie = new Categorie;
        if(!empty($data['categorie_idcategorie']) && !$categorie->selectId($data['categorie_idcategorie'])){
            $val->addError('categorie_idcategorie', "Cette catégorie n'existe pas.");
        }
        $formateur = new Formateur;
        if(!empty($data['formateur_idformateur']) && !$formateur->selectId($data['formateur_idformateur'])){
            $val->addError('formateur_idformateur', "Ce formateur n'existe pas.");
        }
        return $val;
    }

    // ---------- Nouvelle fonctionnalité TP3 : l'image du cours ----------

    // Vérifie l'image envoyée (facultative)
    // Retourne l'extension (jpg, png, webp) si l'image est valide, sinon null
    private function verifierImage($val){
        // Aucun fichier choisi : ce n'est pas une erreur, l'image est facultative
        if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE){
            return null;
        }
        $fichier = $_FILES['image'];

        if($fichier['error'] != UPLOAD_ERR_OK){
            $val->addError('image', "L'image n'a pas pu être envoyée.");
            return null;
        }
        if($fichier['size'] > 2 * 1024 * 1024){
            $val->addError('image', "L'image ne doit pas dépasser 2 Mo.");
            return null;
        }

        // On vérifie le CONTENU du fichier, pas seulement son nom :
        // un fichier virus.php renommé en photo.jpg sera refusé
        // (le @ cache l'avertissement de PHP quand le fichier n'est pas une image)
        $infos = @getimagesize($fichier['tmp_name']);
        $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if($infos === false || !isset($types[$infos['mime']])){
            $val->addError('image', "Le fichier doit être une image JPG, PNG ou WEBP.");
            return null;
        }
        return $types[$infos['mime']];
    }

    // Déplace l'image dans public/uploads avec un nom unique, et retourne ce nom
    private function enregistrerImage($extension){
        $nom = uniqid('cours_').'.'.$extension;
        move_uploaded_file($_FILES['image']['tmp_name'], 'public/uploads/'.$nom);
        return $nom;
    }

    // Supprime une image du dossier public/uploads
    private function supprimerImage($nom){
        if($nom && file_exists('public/uploads/'.$nom)){
            unlink('public/uploads/'.$nom);
        }
    }

    // Données des listes déroulantes du formulaire
    private function listes(){
        $categorie = new Categorie;
        $formateur = new Formateur;
        $cours = new Cours;
        return [
            'categories' => $categorie->select('nom'),
            'formateurs' => $formateur->select('nom'),
            'niveaux'    => $cours->niveaux
        ];
    }
}