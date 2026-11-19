<?php
namespace App\Controllers;

use App\Models\User;
use App\Providers\View;
use App\Providers\Validator;
use App\Providers\Auth;

// Contrôleur de la connexion et de la déconnexion
class AuthController {

    // Affiche le formulaire de connexion
    public function create($data = []){
        $erreur = null;
        // Arrive ici quand Auth::privilege() a refusé l'accès à une page
        if(isset($data['erreur']) && $data['erreur'] == 'acces'){
            $erreur = 'Vous devez être connecté avec le bon compte pour accéder à cette page.';
        }
        return View::render('auth/create', ['erreur' => $erreur]);
    }

    // Traite le formulaire de connexion
    public function store(array $data){
        $val = new Validator;
        $val->field('username', $data['username'], 'Courriel')->required()->email()->max(120);
        $val->field('password', $data['password'], 'Mot de passe')->required()->min(6)->max(20);

        if($val->isSuccess()){
            $user = new User;
            if($user->checkUser($data['username'], $data['password'])){
                // L'administrateur va vers la gestion, le client vers l'accueil
                if(Auth::estAdmin()){
                    return View::redirect('cours');
                }
                    return View::redirect('mon-espace');
            }else{
                // Même message pour un courriel ou un mot de passe faux :
                // on ne dit pas à un pirate lequel des deux existe
                $erreur = 'Courriel ou mot de passe incorrect.';
                return View::render('auth/create', ['erreur' => $erreur, 'user' => $data]);
            }
        }else{
            return View::render('auth/create', ['errors' => $val->getErrors(), 'user' => $data]);
        }
    }

    // Déconnexion : on vide et on détruit la session
    public function delete(){
        $_SESSION = [];
        session_destroy();
        return View::redirect('login');
    }
}