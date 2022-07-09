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
            /* SI RESULT != EMPTY -> REDIRECT /LOGIN */
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $res = $user->checkLogin(); 
            if ($user->getEmail() === $res['email'] && password_verify($_POST['password'], $res['password'])){
                $_SESSION["idUser"] = $res['id'];
                if ($res['status'] === "1") {
                    $_SESSION['isAdmin'] = 1;
                    header("Location: /dashboard" );
                }
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
        echo "Se déco";
    }


    public function pwdforget()
    {
        echo "Mot de passe oublié";
    }

}