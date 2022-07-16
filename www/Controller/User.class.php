<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\MysqlBuilder as MysqlBuilder;
use App\Model\User as UserModel;

class User {

    public function list()
    {
        $user = new userModel();
        $listUser = $user->select();
        $success = (!empty($_GET) && isset($_GET['success']))?htmlspecialchars($_GET['success']):"";
        $view = new View("Users", 'back');
        $view->assign("listUser",$listUser);
        $view->assign("success", $success);
    }

    public function role($data=array())
    {
        if (count($data)>0 && isset($data['id'])) {
            $id = htmlspecialchars($data['id']);
            $user = new userModel();

            $user = $user->getById($id, ['id', 'login', 'email', 'status', 'token']);

            if (!$user) {
                die("404 : User not found");
            }

            if (!empty($_POST)) {
                $status = htmlspecialchars($_POST['status']);
                $user->setStatus($status);
                $res = $user->save();

                if ($res) {
                    header("Location: /administration/users?success=ok");
                    exit();
                }

                header("Location: /administration/users?success=notok");
                exit();
            }
        }
    }

    public function login()
    {
        $user = new UserModel();
        $error = array();
        if (!empty($_POST)) {
            $result = Verificator::checkForm($user->getLoginForm(), $_POST);
            /* SI RESULT != EMPTY -> REDIRECT /LOGIN */
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $req = $user->checkLogin();
            if (count($req)>0) {
                $res = $req[0];
                if ($user->getEmail() === $res->getEmail() && password_verify($_POST['password'], $res->getPassword())) {
                    $_SESSION["idUser"] = $res->getId();
                    $_SESSION["token"] = $res->getToken();
                    if ($res->getStatus() == "1") {
                        $_SESSION['isAdmin'] = 1;
                        header("Location: /administration");
                        exit();
                    }
                    header("Location: /home");
                    exit();
                } else {
                    $error[] = "Mot de passe incorrect";
                }
            } else {
                $error[] = "Email incorrect.";
            }
        }
            // AJOUTER LA REDIRECTION SI USER!=ADMIN-> HOME PAGE
        $view = new View("Login", "front" );
        $view->assign("user", $user);
        $view->assign("errors", $error);
    }


    public function register()
    {

        $user = new UserModel();     
        $error = array();

        if( !empty($_POST)){

            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
            $user->setEmail($_POST['email']);
            $user->setLogin($_POST['login']);
            $user->setPassword($_POST['password']);

            $error = $this->getUnique($user);

            if (count($error)==0) {
                $user->generateToken();
                $user->save();
                header('Location: /login');
                exit();
            }
        
        }

        $view = new View("register");
        $view->assign("user", $user);
        $view->assign("errors",$error);
        exit();
    }

    public function getUnique($user)
    {
        $error = array();
        $email = array(
            "email"=>$user->getEmail()
        );

        $login = array(
            "login"=>$user->getLogin()
        );
        
        $mailcheck = $user->getUnique(['*'],$email);
        $logincheck = $user->getUnique(['*'], $login);

        if ($mailcheck!=false) {
            $error[] = "Mail déjà utilisé.";
        }

        if ($logincheck!=false) {
            $error[] = "Login déjà utilisé.";
        }
        
        return $error;
    }


    public function logout()
    {
        session_destroy();
        header("location: /");
    }


    public function pwdforget()
    {
        echo "Mot de passe oublié";
    }

}





