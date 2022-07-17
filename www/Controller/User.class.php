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
        $error = $success = array();

        if (isset($_GET['confirm'])) {
            $confirm = htmlspecialchars($_GET['confirm']);

            if ($confirm=="success") {
                $success[] = "Vous avez bien confirmé votre compte";
            } elseif ($confirm=="error") {
                $error[] = "Erreur dans la confirmation de votre compte";
            }
        }
        if (!empty($_POST)) {
            $result = Verificator::checkForm($user->getLoginForm(), $_POST);
            /* SI RESULT != EMPTY -> REDIRECT /LOGIN */
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $req = $user->checkLogin();

            if (count($req)>0) {
                $res = $req[0];
                

                if ($user->getEmail() === $res->getEmail() && password_verify($_POST['password'], $res->getPassword())) {
                    if ($res->getConfirmed()==1) {
                        $_SESSION["idUser"] = $res->getId();
                        $_SESSION["token"] = $res->getToken();
                        if ($res->getStatus() == 1 || $res->getStatus() == 2) {
                            $_SESSION['isAdmin'] = $res->getStatus();
                            header("Location: /administration");
                            exit();
                        }
                        header("Location: /");
                        exit();
                    }
                    $error[] = "Veuillez confirmer votre email avant de vous connecter";
                } else {
                    $error[] = "Mot de passe incorrect";
                }
            } else {
                $error[] = "Email incorrect.";
            }
        }

        $view = new View("Login", "front" );
        $view->assign("user", $user);
        $view->assign("errors", $error);
        $view->assign("success", $success);
    }


    public function register()
    {

        $user = new UserModel();     
        $error = $success = array();

        if( !empty($_POST)){

            $result = Verificator::checkForm($user->getRegisterForm(), $_POST);
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setLogin(htmlspecialchars($_POST['login']));
            $user->setPassword(htmlspecialchars($_POST['password']));
            $user->setConfirmed(0);

            $error = $this->getUnique($user);

            if (count($error)==0) {
                $user->generateToken();
                $res = $user->save();
                
                if ($res!==false) {
                    $resbis = $user->sendConfirm($res);
                    $success[] = "Un email de confirmation vous a été envoyé.";
                } else {
                    $error[] = "Erreur dans la sauvegarde de votre user";
                }
            }
        
        }

        $view = new View("register");
        $view->assign("user", $user);
        $view->assign("errors",$error);
        $view->assign("success", $success);
        exit();
    }

    public function forgottenpwd()
    {
        $user = new UserModel();     
        $error = $success = array();

        if( !empty($_POST)){
            $col = ["id","email","token","login"];

            ////VERIFICATION FORM

            $where = array(
                "email"=>htmlspecialchars($_POST['email'])
            );
            $user = $user->getUnique($col, $where);
            
            if ($user!==false) {
                $res = $user->sendResetPwd();
                if ($res=="OK") {
                    $success[] = "Email envoyé avec succès";
                } else {
                    $error[] = "Erreur dans l'envoie de l'email";
                }
            } else {
                $error[] = "Erreur utilisateur non trouvé";
            }
        }

        if ($user===false) {
            $user = new UserModel();
        }

        $view = new View("forgottenpwd");
        $view->assign("user", $user);
        $view->assign("errors",$error);
        $view->assign("success",$success);
    }

    public function confirmuser($data)
    {
        $user = new UserModel();     
        
        if (is_array($data) && isset($data['id']) && isset($data['token'])) {
            $col = ["id","token"];
            $id = htmlspecialchars($data['id']);
            $token = htmlspecialchars($data['token']);
            $user = $user->getById($id, ['id','token']);
            
            if ($user!==false && $token==$user->getToken()) {
                $user->setConfirmed(1);
                $user->generateToken();

                $res = $user->save();

                if ($res!==false) {
                    header('Location: /login?confirm=success');
                    exit();
                }
                header('Location: /login?confirm=error');
                exit();
            }
            header('Location: /login?confirm=error');
            exit();

        }
    }

    public function resetpwd($data=array())
    {
        if (is_array($data) && isset($data['id']) && isset($data['token'])) {
            $error = array();
            $user = new UserModel();

            $id = htmlspecialchars($data['id']);
            $token = htmlspecialchars($data['token']);
            
            $user = $user->getById($id);

            if ($user!==false) {
                if ($user->getToken()==$token) {
                    if (!empty($_POST)) {
                        $user->setPassword(htmlspecialchars($_POST['password']));
                        $user->generateToken();
                        $res = $user->save();
                        
                        if ($res!==false) {
                            header('Location: /login');
                            exit();
                        } else {
                            $error[] = "Erreur dans la modification du mot de passe";
                        }
                    }
                } else {
                    $error[] = "Tokens diffèrents, tentative de hack détectée";
                }
            } else {
                $error[] = "Utilsateur non trouvé";
            }

            $view = new View("resetpwd");
            $view->assign("user", $user);
            $view->assign("errors", $error);
        }
    }


    public function getUnique($user)
    {
        $error = array();

        $email = array(
            "email"=>$user->getEmail()
        );
        $mailcheck = $user->getUnique(['*'],$email);

        $login = array(
            "login"=>$user->getLogin()
        );
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