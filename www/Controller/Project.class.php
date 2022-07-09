<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Project as projectModel;

class Project {

    public function add()
    {
        $project = new projectModel();
        $result = Verificator::checkForm($project->getAddForm(), $_POST);
        $project->setName($_POST['name']);
        $project->setDate($_POST['releaseDate']);
        $project->setDescription($_POST['description']);
        $project->setAuthor($_SESSION['idUser']);
        $project->save();
        header('Location: /administration/projects');
    }


}