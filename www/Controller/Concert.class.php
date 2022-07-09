<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Concert as concertModel;

class Concert {

    public function add()
    {
        $concert = new concertModel();
        $result = Verificator::checkForm($concert->getAddForm(), $_POST);
        $concert->setName($_POST['name']);
        $concert->setDate($_POST['date']);
        $concert->setVenue($_POST['venue']);
        $concert->setCity($_POST['city']);
        $concert->setLink($_POST['link']);
        $concert->save();
        header('Location: /administration/concerts');
    }


}