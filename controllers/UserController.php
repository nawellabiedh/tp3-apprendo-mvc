<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Privilege;
use App\Models\Etudiant;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur des utilisateurs : seul l'administrateur peut créer des comptes
class UserController {

    // Tout ce contrôleur est réservé à l'administrateur
    public function __construct(){
        Auth::privilege(Auth::ADMIN);
    }

    // Liste des comptes avec leur rôle
    public function index(){
        $user = new User;
        $users = $user->selectDetails();
        return View::render('user/index', ['users' => $users]);
    }

    // Formulaire de création
    public function create(){
        return View::render('user/create', $this->listes());
    }

    // Enregistre le nouveau compte
    public function store(array $data){
        $val = new Validator;
        $val->field('nom', $data['nom'] ?? '', 'Le nom')->required()->min(2)->max(100);
        $val->field('username', $data['username'] ?? '', 'Le courriel')->required()->email()->max(120);
        $val->field('password', $data['password'] ?? '', 'Le mot de passe')->required()->min(6)->max(20);
        $val->field('privilege_idprivilege', $data['privilege_idprivilege'] ?? '', 'Le rôle')->required()->in(['1', '2']);

        $user = new User;

        // Le courriel de connexion doit être unique
        if($user->unique('username', $data['username'] ?? '')){
            $val->addError('username', 'Ce courriel est déjà utilisé.');
        }

        if(($data['privilege_idprivilege'] ?? '') == Auth::CLIENT){
            // Un client doit être lié à un étudiant, et un seul compte par étudiant
            if(empty($data['etudiant_idetudiant'])){
                $val->addError('etudiant_idetudiant', 'Choisissez l\'étudiant lié à ce compte client.');
            }elseif($user->unique('etudiant_idetudiant', $data['etudiant_idetudiant'])){
                $val->addError('etudiant_idetudiant', 'Cet étudiant a déjà un compte.');
            }
        }else{
            // Un administrateur n'est lié à aucun étudiant
            $data['etudiant_idetudiant'] = null;
        }

        if($val->isSuccess()){
            // On hache le mot de passe AVANT de l'enregistrer
            $data['password'] = $user->hashPassword($data['password']);
            $user->insert($data);
            return View::redirect('users?message=ajoute');
        }else{
            $listes = $this->listes();
            $listes['errors'] = $val->getErrors();
            $listes['user'] = $data;
            return View::render('user/create', $listes);
        }
    }

    // Listes des menus déroulants du formulaire
    private function listes(){
        $privilege = new Privilege;
        $etudiant = new Etudiant;
        return [
            'privileges' => $privilege->select(),
            'etudiants' => $etudiant->select('nom')
        ];
    }
}