<?php
namespace App\Controller;

use App\Core\CleanWords;
use App\Core\Sql;
use App\Core\Verificator;
use App\Core\View;
use App\Model\User as UserModel;

class User {

    public function login()
    {
        $user = new UserModel();
        if ( !empty($_POST)) {
            $result = Verificator::checkForm($user->getLoginForm(), $_POST);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $res = $user->checkLogin();
            if ($user->getEmail() === $res[0]['email'] && $user->getPassword() === $res[0]['password']){
                $_SESSION["idUser"] = $res[0]['id'];
                if ($res[0]['status'] === 1) {
                    $view = new View("Login", "back");
                }

            }
            // AJOUTER LA REDIRECTION SI USER=ADMIN-> DASHBOARD BACK
            /*$view = new View("Contact", "front" );
            $view->assign("user", $user);*/
        } else {
            // AJOUTER LA REDIRECTION SI USER!=ADMIN-> HOME PAGE
            /*$view = new View("Contact", "front" );
            $view->assign("user", $user);*/
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
        echo "Se déco";
    }


    public function pwdforget()
    {
        echo "Mot de passe oublié";
    }

}





