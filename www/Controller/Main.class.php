<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Page as pageModel;

class Main {

    /**
	 * @return void
	**/
    public function home():void
    {

        $page = new pageModel();
        $navLinks = $page->getNavLink();

        $view = new View("home");
        $view->assign("navLinks", $navLinks);
    }

    /**
	 * @return void
	**/
    public function contact():void
    {
        $view = new View("contact");
    }



}