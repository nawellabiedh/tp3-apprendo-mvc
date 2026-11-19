<?php
namespace App\Controllers;

use App\Providers\View;

// Contrôleur de la page d'accueil (vue statique)
class HomeController {

    public function index(){
        return View::render('home');
    }
}