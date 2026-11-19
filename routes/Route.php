<?php

namespace App\Routes;

// Classe Route : garde la liste des routes du site
// et appelle le bon contrôleur selon l'adresse demandée.
class Route {

    private static $routes = [];

    // Enregistre une route GET (affichage d'une page)
    static public function get(string $url, string $controller):void{
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    // Enregistre une route POST (envoi d'un formulaire)
    static public function post(string $url, string $controller):void{
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    // Cherche la route qui correspond à l'adresse et appelle la méthode du contrôleur
    static public function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        $urlSegments = explode('?', $url);
        $urlPath = rawurldecode($urlSegments[0]);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach(self::$routes as $route){

            if(BASE.$route['url'] == $urlPath && $route['method'] == $method){
                // 'CoursController@index' -> classe CoursController, méthode index
                $controllerSegments = explode('@', $route['controller']);
                $controllerName = 'App\\Controllers\\'.$controllerSegments[0];
                $methodName = $controllerSegments[1];

                $controllerInstance = new $controllerName();

                if($method == "GET"){
                    if(isset($urlSegments[1])){
                        // ?id=3 -> ['id' => 3]
                        parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($queryParams);
                    }else{
                        $controllerInstance->$methodName();
                    }

                }elseif($method == "POST"){
                    if(isset($urlSegments[1])){
                        parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($_POST, $queryParams);
                    }else{
                        $controllerInstance->$methodName($_POST);
                    }
                }
                return;
            }
        }

        // Aucune route trouvée : page 404
        http_response_code(404);
        \App\Providers\View::render('error', ['msg' => 'Code 404 - Page introuvable']);
    }
}