<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Newsletter as newsletterModel;
use App\Model\User as userModel;

class Newsletter {

    public function list() {
        $newsletter = new newsletterModel();
        $list = $newsletter->select();
        $view = new View("newsletter", "back");
        $view->assign("newsletter", $newsletter);
        $view->assign("list", $list);
    }

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

    public function edit()
    {
        $newsletter = new newsletterModel();
        
        if (!empty($_POST)) {
            $data = array(
                "id"=>addslashes($_POST['idnews']),
                "title"=>addslashes($_POST['title']),
                "content"=>addslashes($_POST['content']),
                "date"=>addslashes($_POST['date']),
            );

            $newsletter->setFromArray($data);
            $res = $newsletter->save();

            if ($res) {
                header('Location: /administration/newsletter/edit?id='.$newsletter->getId().'&success=ok');
            }
            header('Location: /administration/newsletter/edit?id='.$newsletter->getId().'&success=notok');
        } else {
            $id = htmlspecialchars($_GET['id']);
            $success = (isset($_GET['success']))?htmlspecialchars($_GET['success']):"";
            $where = array(
                "id"=>$id
            );

            $res = $newsletter->select($where)['0'];
            $newsletter->setFromArray($res);
            $tabSubscribed = $newsletter->getSubscribedUsers($id);
            $idSub = array();
            foreach ($tabSubscribed as $user) {
                $idSub[] = $user['id'];
            }
            $user = new userModel();
            $listUser = $user->select();

            foreach ($listUser as $key => $value) {
                if (in_array($value['id'], $idSub)) {
                    unset($listUser[$key]);
                }
            }

            $view = new View("newsletteredit", "back");
            $view->assign("newsletter", $newsletter);
            $view->assign("subscribed", $tabSubscribed);
            $view->assign("userlist",$listUser);
            $view->assign("success",$success);

        }
    }

    public function subscribe()
    {
        $newsletter = new newsletterModel();

        if (!empty($_POST)) {
            $id_news = addslashes($_POST['id_newsletter']);
            $id_user = addslashes($_POST['id_user']);

            $data = array(
                "id_user"=>$id_user,
                "id_newsletter"=>$id_news
            );

            $res = $newsletter->subscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit?id='.$id_news);
            }
        }
    }


    public function unsubscribe()
    {
        $newsletter = new newsletterModel();

        if (!empty($_POST)) {
            $id_news = addslashes($_POST['id_newsletter']);
            $id_user = addslashes($_POST['id_user']);

            $data = array(
                "id_user"=>$id_user,
                "id_newsletter"=>$id_news
            );

            $res = $newsletter->unsubscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit?id='.$id_news);
            }
        }
    }


}