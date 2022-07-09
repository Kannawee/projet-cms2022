<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Core\MysqlBuilder as MysqlBuilder;
use App\Model\User as UserModel;

class User {

    public function login()
    {
        $user = new UserModel();
        if (!empty($_POST)) {
            $result = Verificator::checkForm($user->getLoginForm(), $_POST);
            /* SI RESULT != EMPTY -> REDIRECT /LOGIN */
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $res = $user->checkLogin()[0];
            if ($user->getEmail() === $res['email'] && password_verify($_POST['password'], $res['password'])) {
                $_SESSION["idUser"] = $res['id'];
                $token = $user->generateToken();
                $_SESSION['token'] =$token;
                var_dump($_SESSION);
                if ($res['status'] == "1") {
                    $_SESSION['isAdmin'] = 1;
                    header("Location: /administration/projects");
                }
                $view = new View("Home", "front");
                $view->assign("user", $user);
                $view->assign("firstname", 'test');
            }
        } else {
            // AJOUTER LA REDIRECTION SI USER!=ADMIN-> HOME PAGE
            $view = new View("Login", "front" );
            $view->assign("user", $user);
        }


    }


    public function register()
    {

        $user = new UserModel();

        if( !empty($_POST)){

            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
            $user->setEmail($_POST['email']);
            $user->setLogin($_POST['login']);
            $user->setPassword($_POST['password']);

            $user->save();
        }

        $view = new View("register");
        $view->assign("user", $user);
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




