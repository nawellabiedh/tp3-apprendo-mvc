<?php
namespace App\Providers;

use App\Providers\View;

// Classe Auth : vérifie si l'utilisateur est connecté et quel est son rôle.
// Rôles (table privilege) : 1 = Administrateur, 2 = Client
class Auth {

    const ADMIN = 1;
    const CLIENT = 2;

    // Vrai si une session valide existe.
    // L'empreinte (fingerPrint) relie la session au navigateur et à l'adresse IP :
    // une session volée et utilisée ailleurs ne sera pas acceptée.
    static public function estConnecte(){
        if(isset($_SESSION['fingerPrint']) && $_SESSION['fingerPrint'] == md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'])){
            return true;
        }
        return false;
    }

    // Vrai si l'utilisateur connecté est administrateur
    static public function estAdmin(){
        return self::estConnecte() && $_SESSION['user_privilege'] == self::ADMIN;
    }

    // Page protégée : si personne n'est connecté, on renvoie vers la connexion
    static public function session(){
        if(!self::estConnecte()){
            View::redirect('login');
        }
        return true;
    }

    // Page réservée à un rôle : sinon, on renvoie vers la connexion
    static public function privilege(int $id){
        self::session();
        if($_SESSION['user_privilege'] != $id){
            View::redirect('login?erreur=acces');
        }
        return true;
    }
}