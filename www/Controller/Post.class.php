<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Post as postModel;

class Post {

    public function list()
    {
        $post = new postModel();
        $listPost = $post->select();
        $view = new View("posts", "back");
        $view->assign("post", $post);
        $view->assign("listPost", $listPost);
    }

    public function add()
    {
        if (!empty($_POST)) {
            $post = new postModel();
            $data = array(
                "title"=>htmlspecialchars($_POST['title']),
                "content"=>htmlspecialchars($_POST['content']),
                "published"=>0,
            );

            $post->setFromArray($data);
            $id = $post->save();

            if (is_numeric($id) && $id!=0) {
                header('Location: /administration/post/edit/'.$id.'?success=ok');
                exit();
            }
            header('Location: /administration/posts?success=notok');
            exit();
        }
    }

    public function edit($data=array())
    {

        if (count($data)>0 && isset($data['id'])) {

            $post = new postModel();
            $id = htmlspecialchars($data['id']);
            
            if (!empty($_POST)) {
                $data = array(
                    "id"=>$id,
                    "title"=>htmlspecialchars($_POST['title']),
                    "content"=>htmlspecialchars($_POST['content']),
                    "published"=>htmlspecialchars($_POST['published']),
                );
                $post->setFromArray($data);
                $res = $post->save();
                if ($res) {
                    header("Location: /administration/post/edit/$id?success=ok");
                    exit();
                }
                header("Location: /administration/post/edit/$id?success=notok");
                exit();

            } else {
                $post = $post->getById($id);
                
                $view = new View("postedit", "back");
                $view->assign("post",$post);
            }
        } else {
            die('Error 404 : params missing');
        }
    }

    public function delete($data)
    {
        
        if (count($data)>0 && isset($data['id'])) {
            $post = new postModel();
            $id = htmlspecialchars($data['id']);

            $where = array(
                "id"=>$id,
            );

            $res = $this->delete($where);

            if ($res) {
                header("Location: /administration/posts?success=ok");
                exit();
            }

            header("Location: /administration/posts?success=notok");
            exit();


        } else {
            die("Error 404 : params missing");
        }
    }

}