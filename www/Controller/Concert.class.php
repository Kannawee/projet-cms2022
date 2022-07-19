<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Concert as concertModel;

class Concert {

    public function list() {
        $concert = new ConcertModel();
        $tabConcerts = $concert->getAll();
        $view = new View("concerts", "back");
        $view->assign("concert", $concert);
        $view->assign("tabConcerts", $tabConcerts);
        $view->assign("errors",[]);
    }

    public function add()
    {
        $concert = new concertModel();
        $error = Verificator::checkForm($concert->getAddForm(), $_POST);

        if (count($error)==0) {
            $concert->setName($_POST['name']);
            $concert->setDate($_POST['date']);
            $concert->setVenue($_POST['venue']);
            $concert->setCity($_POST['city']);
            $concert->setLink($_POST['link']);
            $res = $concert->save();

            if ($res) {
                header('Location: /administration/concerts');
                exit();
            }

            $error[] = "Error during insertion in database";
        }

        $tabConcerts = $concert->getAll();
        $view = new View("concerts", "back");
        $view->assign("concert", $concert);
        $view->assign("tabConcerts", $tabConcerts);
        $view->assign("errors", $error);
    }


}