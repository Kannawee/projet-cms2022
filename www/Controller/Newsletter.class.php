<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\Newsletter as newsletterModel;
use App\Model\User as userModel;
use App\Model\Mymail as mymailModel;

class Newsletter {

    /**
	 * @return void
	**/
    public function list():void
    {
        $newsletter = new newsletterModel();
        $list = $newsletter->select();
        $view = new View("newsletter", "back");
        $view->assign("newsletter", $newsletter);
        $view->assign("list", $list);
    }

    /**
	 * @return void
	**/
    public function add():void
    {
        $newsletter = new newsletterModel();
        $result = Verificator::checkForm($newsletter->getAddForm(), $_POST);
        $newsletter->setTitle(htmlspecialchars($_POST['title']));
        $newsletter->setContent(htmlspecialchars($_POST['content']));
        $newsletter->setType(htmlspecialchars($_POST['type']));
        $newsletter->setActive(0);
        $newsletter->setDate(date('Y-m-d H:i:s'));
        $res = $newsletter->save();

        if ($res) {
            header('Location: /administration/newsletter?success=ok');
            exit();
        }

        var_dump($res);die;
        header('Location: /administration/newsletter?success=notok');
        exit();


    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function edit($data):void
    {

        $newsletter = new newsletterModel();
        
        if (!empty($_POST)) {
            $data = array(
                "id"=>htmlspecialchars($_POST['idnews']),
                "title"=>htmlspecialchars($_POST['title']),
                "content"=>htmlspecialchars($_POST['content']),
                "date"=>htmlspecialchars($_POST['date']),
                "active"=>htmlspecialchars($_POST['active']),
                "type"=>htmlspecialchars($_POST['type']),
            );

            $newsletter->setFromArray($data);
            $res = $newsletter->save();

            if ($res) {
                header('Location: /administration/newsletter/edit/'.$newsletter->getId().'?success=ok');
            } else {
                header('Location: /administration/newsletter/edit/'.$newsletter->getId().'?success=notok');
            }
        } else {
            $id = htmlspecialchars($data['idnews']);
            $success = (isset($_GET['success']))?htmlspecialchars($_GET['success']):"";
            $where = array(
                "id"=>$id
            );

            // $res = $newsletter->select($where)['0'];
            $newsletter = $newsletter->getById($id, $col=['*']);

            $users = new userModel();
            
            $subscribedUsers = $users->getSubscribedUsers();

            $idSub = array();
            foreach ($subscribedUsers as $user) {
                $idSub[] = $user->getId();
            }
            $user = new userModel();
            $listUser = $user->select();

            foreach ($listUser as $key => $value) {
                if (in_array($value->getId(), $idSub)) {
                    unset($listUser[$key]);
                }
            }

            $view = new View("newsletteredit", "back");
            $view->assign("newsletter", $newsletter);
            $view->assign("subscribed", $subscribedUsers);
            $view->assign("userlist",$listUser);
            $view->assign("success",$success);

        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function subscribe($data=array()):void
    {
        $newsletter = new newsletterModel();

        if (!empty($data) && count($data)>0) {
            $id_user = htmlspecialchars($data['iduser']);
            $id_news = htmlspecialchars($data['idnews']);

            $data = array(
                "id_user"=>$id_user
            );

            $res = $newsletter->subscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit/'.$id_news);
            }
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function unsubscribe($data):void
    {
        $newsletter = new newsletterModel();

        if (!empty($data)) {
            $id_news = addslashes($data['idnews']);
            $id_user = addslashes($data['iduser']);

            $data = array(
                "id_user"=>$id_user,
            );

            $res = $newsletter->unsubscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit/'.$id_news);
            }
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function send($data=array()):void
    {
        $newsletter = new newsletterModel();

        if (!empty($data) && count($data)>0) {
            $id_news = addslashes($data['idnews']);
            $tmp_tab = $newsletter->getNewsById($id_news);
            
            if (count($tmp_tab)>0) {
                $newscontent = $tmp_tab[0];
                $newsletter->setFromArray($newscontent);
                $emails = $newsletter->listemail();

                foreach ($emails as $email) {
                    $tmp_mail = array();
                    $tmp_mail[] = $email['email'];

                    $mail = new mymailModel();
                    $mail->setupMyMail($newsletter->getTitle(), $newsletter->getContent(), $tmp_mail);
                    $res = $mail->sendMyMail();

                    if ($res!="OK") {
                        header('Location: /administration/newsletter/edit/'.$id_news.'?success=notsent');
                        exit();
                    }
                }
            }

            header('Location: /administration/newsletter/edit/'.$id_news.'?success=sent');
            exit();
        }
    }

    /**
	 * @param array $data
	 * @return void
	**/
    public function delete($data=array()):void
    {
        $newsletter = new newsletterModel();

        if (count($data)>0 && isset($data['id'])) {

            $tmp_data = array(
                "id"=>htmlspecialchars($data['id'])
            );

            $newsletter->setFromArray($tmp_data);

            $res = $newsletter->delete();

            if ($res) {
                header('Location: /administration/newsletter?success=ok');
                exit();
            } else {                
                header('Location: /administration/newsletter?success=notok');
                exit();
            }
        }
    }

}