<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Media as mediaModel;
use App\Model\Project as projectModel;

class Project {

    public function list() {
        $project = new ProjectModel();
        $tabProjects = $project->getAll();

        $view = new View("projects", "back");
        $view->assign("project", $project);
        $view->assign("projectTab", $tabProjects);
    }


    public function edit($data=array())
    {
        $project = new projectModel();

        if (!empty($data) && count($data)>0) {

            $id = htmlspecialchars($data['id']);

            if (!empty($_POST)) {
                $data = array(
                    "id"=>$id,
                    "name"=>htmlspecialchars($_POST['name']),
                    "releaseDate"=>htmlspecialchars($_POST['releaseDate']),
                    "description"=>htmlspecialchars($_POST['description']),
                );

                $project->setFromArray($data);
                $res = $project->save();

                if ($res) {
                    header('Location: /administration/project/edit/'.$project->getId()."?success=ok");
                    exit();
                }

                header('Location: /administration/project/edit/'.$project->getId()."?success=notok");
                exit();
            } else {
                $project = $project->getById($id);
                $success = (isset($_GET['success']))?htmlspecialchars($_GET["success"]):"";
                $view = new View("projectedit", "back");
                $view->assign('project', $project);
                $view->assign('success',$success);
                exit();
            }

        }
    }

    public function add()
    {
        $project = new projectModel();
        if (!empty($_POST)) {
            $result = Verificator::checkForm($project->getAddForm(), $_POST);
            $data = array(
                "name"=>htmlspecialchars($_POST['name']),
                "releaseDate"=>htmlspecialchars($_POST['releaseDate']),
                "description"=>htmlspecialchars($_POST['description']),
            );

            $project->setFromArray($data);
            $res = $project->save();

            if (is_numeric($res) && $res!=0) {
                header('Location: /administration/project/edit/'.$res.'?success=ok');
                exit();
            }

            header('Location: /administration/projects?success=notok');
            exit();
        }
    }

    public function delete($data=array())
    {
        if (count($data)>0 && isset($data['id'])) {
            $id = htmlspecialchars($data['id']);

            $project = new projectModel();

            $project = $project->getById($id);

            if ($project) {
                $where = array(
                    "id"=>$id
                );
                $res = $project->delete($where);

                if ($res) {
                    header("Location: /administration/projects?success=ok");
                    exit();
                }

                header("Location: /administration/projects?success=notok");
                exit();
            }
        } else {
            die("Missing parameters");
        }
    }


}