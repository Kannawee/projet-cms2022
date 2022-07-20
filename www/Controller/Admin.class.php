<?php

namespace App\Controller;

use App\Core\View;
use App\Model\User as UserModel;
use App\Model\Project as ProjectModel;
use App\Model\Tracklist as TracklistModel;
use App\Model\Concert as ConcertModel;
use App\Model\Newsletter as NewsletterModel;


class Admin
{
    /**
	 * @return void
	**/
    public function dashboard():void
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

    /**
	 * @return void
	**/
    public function users():void
    {
        $view = new View("users", "back");
    }

    /**
	 * @return void
	**/
    public function templates():void
    {
        $view = new View("templates", "back");
    }

    /**
	 * @return void
	**/
    public function isAdmin():void
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

}