<?php
declare(strict_types=1);

    /**
     * ------------------------------------------------------------------------
     *                                   Le routeur
     * -----------------------------------------------------------------------
     */


    /**
     * Cette function du routeur lui permet de récupérer chaque route dont l'application
     * attent la reception via la methode "GET"
     *
     * @param string $request_route
     * @param array $action_route
     * @return void
     */
    function get(string $request_route, array $action_route) : void 
    {
        collectRoutes("GET", $request_route, $action_route);
    }

        /**
     * Cette function du routeur lui permet de récupérer chaque route dont l'application
     * attent la reception via la methode "POST"
     *
     * @param string $request_route
     * @param array $action_route
     * @return void
     */
    function post(string $request_route, array $action_route) : void 
    {
        collectRoutes("POST", $request_route, $action_route);
        
    }


    /**
     * Cette methode collecte les routes dont l'application attend la réception 
     * via la methode "GET" et "POST"
     *
     * Zlle stocke ensuite ces routes dans un tableau à route en prenant soin
     * le lès trier par methode d'envoi
     * 
     * @param string $method
     * @param string $request_route
     * @param array $action_route
     * 
     * @return void
     */
    function collectRoutes(string $method, string $request_route, array $action_route) : void
    {
        // Tableau d routes
        global $routes;
        $route = [];

        $route[] = $request_route;
        $route[] = $action_route;

        $routes[$method][] = $route;
    }

    

    /**
     * Cette function du routeur lui permet de s'executer et de retourner :
     *      - soit un tableau si les routes ont matché
     *      - soit null si les routes n'ont pas matché
     *
     * @return array|null
     */
    function run() : ?array
    {
        global $routes;
        
       $request_uri = $_SERVER['REQUEST_URI'];

       foreach ($routes[$_SERVER['REQUEST_METHOD']] as $route) {
            // Récupérer la requête du client dans la barre d'url 
            // en protégeant le serveur contre les failles de type XSS
            $request_uri = strip_tags(urldecode(parse_url(trim($_SERVER['REQUEST_URI']), PHP_URL_PATH)));

            // Récupérer l'url dont l'application attend la visite
            $request_route = $route[0];

            $pattern = preg_replace("#{[a-z]+}#", "([0-9a-zA-Z-_])", $request_route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $request_uri, $matches)) 
            {
                array_shift($matches);
                $parameters = $matches;

                $controller = $route[1][0];
                $method     = $route[1][1];

                if ($parameters) {
                    return [
                        "controller" => $controller,
                        "method" => $method,
                        "parameters" => $parameters
                    ];
                }

                return [
                    "controller" => $controller,
                    "method" => $method,
                ];

            }

        }

        return null;
    }