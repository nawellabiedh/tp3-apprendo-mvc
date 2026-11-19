<?php
namespace App\Controllers;

use App\Models\Etudiant;
use App\Models\Inscription;
use App\Providers\View;
use App\Providers\Auth;

// Contrôleur de l'espace client : chaque client voit seulement ses propres données
class ClientController {

    // Tout ce contrôleur est réservé au client
    public function __construct(){
        Auth::privilege(Auth::CLIENT);
    }

    // Mon espace : mes informations et mes cours suivis
    public function index(){
        // L'id vient de la session, jamais de l'URL :
        // un client ne peut donc pas voir les données d'un autre étudiant
        $idEtudiant = $_SESSION['etudiant_id'];

        if($idEtudiant){
            $etudiant = new Etudiant;
            $unEtudiant = $etudiant->selectId($idEtudiant);

            $inscription = new Inscription;
            $coursSuivis = $inscription->selectByEtudiant($idEtudiant);

            return View::render('client/index', ['etudiant' => $unEtudiant, 'coursSuivis' => $coursSuivis]);
        }
        return View::render('error', ['msg' => 'Aucun profil étudiant n\'est lié à ce compte.']);
    }
}