<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Comment as commentModel;

class Comment {

    public function listUnmod()
    {
        $comment = new commentModel();
        $success = (isset($_GET['success']))?htmlspecialchars($_GET['success']):"";
        $listComment = $comment->getListUnmod();

        $view = new View("comment","back");
        $view->assign("success",$success);
        $view->assign("listComment", $listComment);
    }

    public function accept($data=array())
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

    public function decline($data=array())
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