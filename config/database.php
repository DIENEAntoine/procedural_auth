<?php
/* Connexion à une base ODBC avec l'invocation de pilote */
$dsn = 'mysql:dbname=dwwm8b_auth;host=127.0.0.1';
$user_db = 'root';
$password_db = '';

try 
{
    $db = new PDO($dsn, $user_db, $password_db);
} 
catch (\PDOException $e) 
{
    die("Error: " . $e->getMessage());
}

?>
