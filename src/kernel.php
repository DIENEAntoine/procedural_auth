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

// Chargement de l'autoloader de composer
require __DIR__ . "/../vendor/autoload.php";


// Chargement du routeur
require __DIR__ . "/z/routing/router.php";


// Chargement des routes dont l'application attend la réception
require __DIR__ . "/../config/routes.php";

// Execution du router 
$router_response = run();

 dd($router_response);