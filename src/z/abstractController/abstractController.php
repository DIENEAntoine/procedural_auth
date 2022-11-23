<?php

    /**
     * Cette methode prend en paramétre, le nom de la vue dont elle doit extraire
     * et rend le contenu
     *
     * @param string $view_name
     * 
     * @return string
     */
    function render($view_name) : string 
    {
        ob_start();
        require TEMPLATES . "$view_name";
        $content = ob_get_clean();

        ob_start();
        require TEMPLATES . "$theme";
        $page = ob_get_clean();

        return $page;
    }



    /**
     * Cette fonction permet au pages d'heriter d'un theme
     *
     * @param string $theme_name
     * 
     * @return string
     */
    function extends_of($theme_name) : string
    {
        return $theme_name;
    }


    /**
     * Cette fonction vérifie si l'utilisateur est connecté ou non
     *
     * @return boolean
     */
    function get_user() : bool
    {
        if (isset($_SESSION['auth']) && !empty($_SESSION['auth']) ) 
        {
            return true;
        }
        return false;
    }