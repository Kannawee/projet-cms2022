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

    public function edit($data)
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
            
            $subscribedUsers = $users->getSubscribedUsers($id);

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

    public function subscribe($data=array())
    {
        $newsletter = new newsletterModel();

        if (!empty($data) && count($data)>0) {
            $id_news = addslashes($data['idnews']);
            $id_user = addslashes($data['iduser']);

            $data = array(
                "id_user"=>$id_user,
                "id_newsletter"=>$id_news
            );

            $res = $newsletter->subscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit/'.$id_news);
            }
        }
    }


    public function unsubscribe($data)
    {
        $newsletter = new newsletterModel();

        if (!empty($data)) {
            $id_news = addslashes($data['idnews']);
            $id_user = addslashes($data['iduser']);

            $data = array(
                "id_user"=>$id_user,
                "id_newsletter"=>$id_news
            );

            $res = $newsletter->unsubscribe($data);
            
            if ($res) {
                header('Location: /administration/newsletter/edit/'.$id_news);
            }
        }
    }


    public function send($data=array())
    {
        $newsletter = new newsletterModel();

        if (!empty($data) && count($data)>0) {
            $id_news = addslashes($data['idnews']);
            $tmp_tab = $newsletter->getNewsById($id_news);
            
            if (count($tmp_tab)>0) {
                $newscontent = $tmp_tab[0];
                $newsletter->setFromArray($newscontent);
                $emails = $newsletter->listemail($id_news);

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


    public function delete($data=array())
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


    public function test($data)
    {
        echo "ID USER : ".$data['iduser']."<br>ID NEWS : ".$data['idnews'];die;
    }


}