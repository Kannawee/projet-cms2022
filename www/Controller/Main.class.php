<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Page as pageModel;

class Main {

    public function home()
    {

        $page = new pageModel();
        $navLinks = $page->getNavLink();

        $view = new View("home");
        $view->assign("navLinks", $navLinks);
    }


    public function contact()
    {
        $view = new View("contact");
    }



}