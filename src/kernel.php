<?php
declare(strict_types=1);


/**-----------------------------------------------------------------
 *                           Le Kernel
 * 
 *          Ce fichier représente le noyeau de l'application
 * 
 * @author Antoine DIENE <diene1antoine@gmail.com>
 * @version 1.0.0
 * ------------------------------------------------------------------
*/

// Chargement des raccourcis (constantes)
require __DIR__ . "/../config/constants.php";

// Chargement de l'autoloader de composer
require ROOT . "vendor/autoload.php";


// Chargement du routeur
require ROUTER;

// Chargement des routes dont l'application attend la réception
require ROUTES;

// Execution du router 
$router_response = run();


return getContollerResponse($router_response);

/**
 * C'est garce à cette function que le kernel demande au controller de s'éxecuter et de lui retourner
 * la réponse correspondante à la rêquete
 * 
 *
 * @param array|null $router_response
 * @return void
 */
function getContollerResponse(array|null $router_response) : string
{
    // Si aucun controlleur n'a été trouvé par le router, 
    // Le noyau demande au controller des erreurs d'activer sa methode notFound() 
    if ( $router_response === null ) 
    {
        require CONTROLLER . "error/errorController.php";
        http_response_code(404);
        return notFound();
    }

    // Dans le cas contraire,
    // Récupérer le contrôlleur et la méthode
    $controller = $router_response['controller'];
    $method     = $router_response['method'];

    // S'il ya des paramétres, charger le controller
    // Executer sa methode prévu en lui passant les paramétres
    if (isset($router_response['parameters']) && !empty($router_response['parameters'])) 
    {
        $parameters = $router_response['parameters'];
        require CONTROLLER . "$controller.php";
        return $method($parameters);
    }

    // Dans le cas contraire,
    // Charger le controller
    // Executer sa methode prévue sans paramétres.
    require CONTROLLER . "$controller.php";
    return $method();

}
