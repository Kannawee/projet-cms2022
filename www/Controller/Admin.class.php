<?php

namespace App\Controller;

class Admin
{

    public function dashboard()
    {
        if (isset($_SESSION["userId"]) && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === 1){
            echo "Ceci est un beau dashboard";
        } else {
            if (isset($_SESSION["userId"])) {
                header("Location: /");
            } else {
                header("Location: /login");
            }
        }
    }

    public function isAdmin() {
        if (isset($_SESSION["userId"]) && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === 1){
            echo "Ceci est un beau dashboard";
        } else {
            if (isset($_SESSION["userId"])) {
                header("Location: /");
            } else {
                header("Location: /login");
            }
        }
    }

}