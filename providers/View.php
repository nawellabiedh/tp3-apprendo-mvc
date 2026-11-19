<?php
namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Classe View : affiche les vues Twig et fait les redirections
class View {

    // Messages de confirmation affichés après une redirection (ex. : cours?message=ajoute)
    static private $messages = [
        'ajoute'   => 'Ajout effectué avec succès.',
        'modifie'  => 'Modifications enregistrées.',
        'supprime' => 'Suppression effectuée.',
        'inscrit'  => "L'étudiant a été inscrit au cours.",
        'retire'   => "L'étudiant a été retiré du cours."
    ];

    // Affiche une vue Twig du dossier views (ex. : 'cours/index')
    static public function render(string $template, $data = []){
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $twig->addGlobal('asset', ASSET);
        $twig->addGlobal('base', BASE);
             // Informations de connexion disponibles dans toutes les vues
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('guest', !Auth::estConnecte());
        $twig->addGlobal('admin', Auth::estAdmin());

        // Message de confirmation, s'il y en a un dans l'adresse
        if(isset($_GET['message']) && isset(self::$messages[$_GET['message']])){
            $twig->addGlobal('message', self::$messages[$_GET['message']]);
        }
        echo $twig->render($template.".php", $data);
    }
    // Redirige vers une autre route (ex. : 'cours/show?id=3')
    // exit arrête le script : rien ne s'exécute après la redirection.
    static public function redirect(string $url){
        header('location:'.BASE.'/'.$url);
        exit;
    }
}