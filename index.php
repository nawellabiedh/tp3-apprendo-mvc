<?php
use App\Models\Journal;

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
require_once 'vendor/autoload.php';
require_once 'config.php';

// Journal de bord : on enregistre chaque visite avant d'afficher la page
$journal = new Journal;
$journal->insert([
    'ip' => $_SERVER['REMOTE_ADDR'],
    'utilisateur' => $_SESSION['username'] ?? 'Visiteur',
    'page' => $_SERVER['REQUEST_URI']
]);

require_once 'routes/web.php';