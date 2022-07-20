<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Post as postModel;

class Post {

    /**
	 * @return void
	**/
    public function list():void
    {
        $post = new postModel();
        $listPost = $post->select();
        $view = new View("posts", "back");
        $view->assign("post", $post);
        $view->assign("listPost", $listPost);
    }

    /**
	 * @return void
	**/
    public function add():void
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function edit($data=array()):void
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

    /**
	 * @param array $data
	 * @return void
	**/
    public function delete($data):void
    {
        
        if (count($data)>0 && isset($data['id'])) {
            $post = new postModel();
            $id = htmlspecialchars($data['id']);

            $where = array(
                "id"=>$id,
            );

            $post->setFromArray($where);

            $res = $post->delete();

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