<?php
// ----------------------------------------------------------------
// Adresse de base du projet
// Calculée automatiquement à partir de l'emplacement de index.php :
//   C:\xampp\htdocs\tp2\apprendo-mvc  ->  /tp2/apprendo-mvc
//   public_html/apprendo-mvc (WebDev)  ->  /apprendo-mvc
// ----------------------------------------------------------------
define('BASE', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
define('ASSET', BASE.'/public');

// ----------------------------------------------------------------
// Connexion à la base de données
// Sur WebDev, remplacer ces 4 valeurs par celles de votre base.
// ----------------------------------------------------------------
define('DB_HOST', 'localhost');
define('DB_NAME', 'cours_en_ligne');
define('DB_USER', 'root');
define('DB_PASS', '');
?>