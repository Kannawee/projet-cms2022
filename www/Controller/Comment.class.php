<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Comment as commentModel;

class Comment {

    /**
	 * @return void
	**/
    public function listUnmod():void
    {
        $comment = new commentModel();
        $success = (isset($_GET['success']))?htmlspecialchars($_GET['success']):"";
        $listComment = $comment->getListUnmod();

        $view = new View("comment","back");
        $view->assign("success",$success);
        $view->assign("listComment", $listComment);
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function add($data=array()):void
    {
        if (!empty($data['type']) && !empty($data['id_obj'])) {
            $comm = new commentModel();

            $type = htmlspecialchars($data['type']);
            $key = "id_".$type;
            $id_obj = htmlspecialchars($data['id_obj']);
            $id_user = $_SESSION['idUser'];

            $content = htmlspecialchars($_POST['content']);
            $redirect = htmlspecialchars($_POST['redirect']);

            $error = Verificator::checkForm($comm->getAddForm($type, $id_obj, $redirect), $_POST);

            if (count($error)==0) {

                $tmpdata = array(
                    $key=>$id_obj,
                    "id_user"=>$id_user,
                    "type"=>$type,
                    "content"=>$content,
                    "moded"=>0
                );

                $comm->setFromArray($tmpdata);
                $res = $comm->save();

                if ($res) {
                    header("Location: /page/".$redirect."?success=ok");
                    exit();
                }

                header("Location: /page/".$redirect."?success=nok");
                exit();

            }
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function accept($data=array()):void
    {
        if (isset($data['id'])) {
            $id = htmlspecialchars($data['id']);
            $comment = new commentModel();
            $comment = $comment->getById($id);

            if ($comment!==false) {
                $comment->setModed(1);
                $res = $comment->save();

                if ($res!==false) {
                    header("Location: /administration/commentmod?success=ok");
                    exit();
                }
                header("Location: /administration/commentmod?success=notok");
                exit();

            }

            header("Location: /administration/commentmod?success=notok");
            exit();
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function decline($data=array()):void
    {
        if (isset($data['id'])) {
            $id = htmlspecialchars($data['id']);
            $comment = new commentModel();
            $comment = $comment->getById($id);

            if ($comment!==false) {
                $res = $comment->delete();

                if ($res!==false) {
                    header("Location: /administration/commentmod?success=ok");
                    exit();
                }
                header("Location: /administration/commentmod?success=notok");
                exit();

            }

            header("Location: /administration/commentmod?success=notok");
            exit();
        }
    }

}