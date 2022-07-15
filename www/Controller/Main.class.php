<?php

namespace App\Controller;

use App\Core\View;

class Main {

    public function home()
    {
        $connect = false;
        if (isset($_SESSION['idUser']) && $_SESSION['idUser']!=0) {
            $connect = true;
        }

        $view = new View("home");
        $view->assign("connect", $connect);
    }


    public function contact()
    {
        $view = new View("contact");
    }



}