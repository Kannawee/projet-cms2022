<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Newsletter as newsletterModel;

class Newsletter {

    public function add()
    {
        $newsletter = new newsletterModel();
        $result = Verificator::checkForm($newsletter->getAddForm(), $_POST);
        $newsletter->setTitle($_POST['title']);
        $newsletter->setContent($_POST['content']);
        $newsletter->setDate(date('Y-m-d H:i:s'));
        $newsletter->save();
        header('Location: /administration/newsletter');
    }


}