<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User as UserModel;
use App\Model\Project as ProjectModel;


class Admin
{

    public function dashboard()
    {
        if (isset($_SESSION["userId"]) && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === 1) {
            echo "Ceci est un beau dashboard";
        } else {
            if (isset($_SESSION["userId"])) {
                header("Location: /");
            } else {
                header("Location: /login");
            }
        }
    }

    public function users() {
        $view = new View("users", "back");
    }

    public function projects() {
        $project = new ProjectModel();
        $view = new View("projects", "back");
        $view->assign("project", $project);
    }

    public function concerts() {
        $view = new View("concerts", "back");
    }

    public function newsletter() {
        $view = new View("newsletter", "back");
    }

    public function templates() {
        $view = new View("templates", "back");
    }

    public function isAdmin() {
        if (isset($_SESSION["userId"]) && isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === 1) {
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