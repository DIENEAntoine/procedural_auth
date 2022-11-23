<?php
declare(strict_types=1);

require ABSTRACT_CONTROLLER;

        
    /**
     * Cette fonction fait 2 choses : 
     *  - Permettre au visiteur d'accéder à la page de connexion
     *  - Connecter ce dernier si ses identifiants sont corrects
     *
     * @return string
     */

    function login() : string
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") 
        {
            require VALIDATOR;

            $errors = make_validation(
                $_POST, 
                [
                    "email" => ["required", "string", "min::5", "max::255", "email"],
                    "password" => ["required", "string", "min::8", "max::255", "regex::/(?=(?:.*[A-Z]){1,})(?=(?:.*[a-z]){1,})(?=(?:.*\d){1,})(?=(?:.*[!@#$%^&*()\-_=+{};:,<.>]){1,})(.{8,255})/"]

                ],
                [
                    "email.required"                => "L'email est obligatoire.",
                    "email.string"                  => "Veuillez entrer une chaîne de caractères.",
                    "email.min"                     => "L'email doit contenir au minimum 5 caractères.",
                    "email.max"                     => "L'email doit contenir au maximum 255 caractères.",
                    "email.email"                   => "Veillez entrer un email valide.",
                    "email.unique"                  => "Impossible de créer un compte avec cet email.",

                    "password.required"             => "Le mot de passe est obligatoire.",
                    "password.string"               => "Veuillez entrer une chaîne de caractères.",
                    "password.min"                  => "Le mot de passe doit contenir au minimum 8 caractères.",
                    "password.max"                  => "Le mot de passe doit contenir au maximum 255 caractères.",
                    "password.regex"                => "Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un caractère spécial et un chiffre.",
                ]
            );

            if ( count($errors) > 0) 
            {
                $_SESSION['errors'] = $errors;
                $_SESSION['old']  = old_values($_POST);

                return redirect_back();;
            }

            require AUTHENTICATOR;
            $response = authenticateUser(old_values($_POST));

            if ($user === null) 
            {
                $_SESSION['bad_credentials'] = "Vos idenfiants sont incorrects";
                $_SESSION['old']             = old_values($_POST);                
                return redirect_back();
            }

            $_SESSION['auth'] = $response;

            return redirect_to_url("/");

        }

        return render("pages/visitor/authentication/login.html.php");
    }