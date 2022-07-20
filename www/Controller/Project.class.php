<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Media as mediaModel;
use App\Model\Project as projectModel;
use App\Model\Comment as commentModel;

class Project {

    /**
	 * @return void
	**/
    public function list():void
    {
        $project = new ProjectModel();
        $tabProjects = $project->select();

        $view = new View("projects", "back");
        $view->assign("project", $project);
        $view->assign("tabProjects", $tabProjects);
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function edit($data=array()):void
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
            }
            
            $project = $project->getById($id);
            if ($project!==false) {
                $success = (isset($_GET['success']))?htmlspecialchars($_GET["success"]):"";

                $comment = new commentModel();
                $listComment = $comment->getModedCommentFromObjId($project->getId(), "project");

                $view = new View("projectedit", "back");
                $view->assign("listComment",$listComment);
                $view->assign('project', $project);
                $view->assign('success',$success);
                exit();
            }
            
            header("Location: /administration/projects");
            exit();

        }

    }

    /**
	 * @return void
	**/
    public function add():void
    {
        $project = new projectModel();
        if (!empty($_POST)) {
            $result = Verificator::checkForm($project->getAddForm(), $_POST, $_FILES);
            $data = array(
                "name"=>htmlspecialchars($_POST['name']),
                "releaseDate"=>htmlspecialchars($_POST['releaseDate']),
                "description"=>htmlspecialchars($_POST['description']),
                "cover"=>null,
            );

            $project->setFromArray($data);            
            $res = $project->save();

            if (is_numeric($res) && $res!=0) {
                if (isset($_FILES) && is_array($_FILES) && $_FILES['name']!="") {
                    $project = $project->getById($res);
                    $project->setCover($_FILES['cover']);
                    $rescover = $project->save();
                }
                // move_uploaded_file($_FILES['picture1']['tmp_name'], $image_path1);
                header('Location: /administration/project/edit/'.$res.'?success=ok');
                exit();
            }

            header('Location: /administration/projects?success=notok');
            exit();
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function delete($data=array()):void
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function seeproject($data=array()):void
    {
        if (isset($data['id'])) {
            $project = new projectModel();
            $id = htmlspecialchars($data['id']);

            $tmpproject = $project->getById($id);

            var_dump($tmpproject);die;
        }
    }


}