<?php
namespace App\Controllers;

use App\Models\Journal;
use App\Providers\View;
use App\Providers\Auth;

// Contrôleur du journal de bord : réservé à l'administrateur
class JournalController {

    public function __construct(){
        Auth::privilege(Auth::ADMIN);
    }

    // Liste des visites, la plus récente en premier
    public function index(){
        $journal = new Journal;
        $visites = $journal->select('date_visite', 'DESC');
        return View::render('journal/index', ['visites' => $visites]);
    }
} 