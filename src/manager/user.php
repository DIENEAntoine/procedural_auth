<?php

   /**
     * ---------------------------------------------------------------------
     * Le manager de la table "user"
     * 
     * Le rôle du manager est d'effectuer toutes les requêtes prévues 
     * pour intéragir avec la base de données
     * ---------------------------------------------------------------------
    */

    /**
     * Grace à cette fonction le manager de la table "user" inscrit un vouvelle utilisateur.
     *
     * @return void
     */
    function createUser(array $data) : void
    {
        require DB;

        // dd($data);

        $req = $db->prepare("INSERT INTO user (first_name, last_name, email, password, created_at, updated_at) VALUE (:first_name, :last_name, :email, :password, now(), now() ) ");

        $req->bindValue(":first_name", $data['first_name']);
        $req->bindValue(":last_name", $data['last_name']);
        $req->bindValue(":email", $data['email']);
        $req->bindValue(":password", password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));

        $req->execute();
        $req->closeCursor();
    }