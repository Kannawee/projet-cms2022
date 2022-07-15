<?php

namespace App;

require "conf.inc.php";

function myAutoloader($class)
{
    // $class => CleanWords
    $class = str_replace("App\\","",$class);
    $class = str_replace("\\", "/",$class);
    if(file_exists($class.".class.php")){
        include $class.".class.php";
    }
}

spl_autoload_register("App\myAutoloader");

$params = array();
$controller = $action = "";

if (!file_exists("conf_perso.inc.php")) {

    $controller = "Installer";
    $action = "install";
    
} else {
    if (session_status() != PHP_SESSION_ACTIVE) {

        session_start();
    
    }
    
    
    
    if (session_status() != PHP_SESSION_ACTIVE) {
    
        session_start();
    
    }
    
    
    
    //Réussir à récupérer l'URI
    
    $uri =  strtok($_SERVER["REQUEST_URI"], '?');
    
    $uri = ($uri=="/")?$uri:rtrim($uri, "/");
    
    
    
    
    
    $routeFile = "routes.yml";
    
    if(!file_exists($routeFile)){
    
    }
    
    
    
    $routes = yaml_parse_file($routeFile);
    
    $tmp_param = array();
    
    $tmp_controller = $tmp_action = "";
    
    $checkRoute = false;
    
    
    
    
    
    if( empty($routes[$uri]) ||  empty($routes[$uri]["controller"])  ||  empty($routes[$uri]["action"])){
    
        
    
        $explode_uri = explode('/',trim($uri, "/"));
    
    
    
        foreach ($routes as $path => $val) {
    
    
    
            $param = array();
    
            $tmp_explode_uri = $explode_uri;
    
    
    
            $checkRoute = false;
    
            
    
            if (!empty($val['param'])) {
    
                $tmp_explode_path = explode("/", trim($path,"/"));
    
                
    
                foreach ($tmp_explode_path as $key => $value) {
    
    
    
                    if (preg_match('/{.*}/',$value)==1) {
    
    
    
                        unset($tmp_explode_path[$key]);
    
    
    
                        if (isset($tmp_explode_uri[$key])) {
    
                            unset($tmp_explode_uri[$key]);
    
                        } else {
    
                            $checkRoute = false;
    
                            break;
    
                        }
    
                    }
    
                }
    
                if (implode("/", $tmp_explode_path)==implode("/", $tmp_explode_uri)) {
    
                    $checkRoute = true;
    
                }
    
    
    
                if ($checkRoute) {
    
                    foreach ($val['param'] as $key => $prm) {
    
                        $tmp_explode = explode("/", trim($path,"/"));
    
                        foreach ($tmp_explode as $ind => $value) {
    
                            if ($value=="{".$prm."}") {
    
                                if (isset($explode_uri[$ind])) {
    
                                    $param[$prm] = $explode_uri[$ind];
    
                                } else {
    
                                    $checkRoute = false;
    
                                }
    
                            }
    
                        }
    
                    }
    
                    $tmp_param = $param;
    
                    $tmp_controller = $val['controller'];
    
                    $tmp_action = $val['action'];
    
    
    
                    if ($checkRoute) {
    
                        break;
    
                    }
    
                }
    
    
    
            }
    
        }
    
        
    
        if (!$checkRoute) {
    
            die("Erreur 404");
    
        }
    
    }
    
    
    
    if (!empty($routes[$uri]['security'])) {
    
        foreach ($routes[$uri]['security'] as $role) {
    
            if ($role=='admin' && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']!=1) {
    
                die('Error : pas la permission.');
    
            } else if ($role=='user' && !isset($_SESSION['idUser'])) {
    
                die('Error : pas la permission.');
    
            }
    
        }
    
    }
    
    
    
    $controller = $action = "";
    
    $params = array();
    
    
    
    if (!$checkRoute) {
    
        $controller = ucfirst(strtolower($routes[$uri]["controller"]));
    
        $action = strtolower($routes[$uri]["action"]);
    
    } else {
    
        $controller = ucfirst(strtolower($tmp_controller));
    
        $action = strtolower($tmp_action);
    
        $params = $tmp_param;
    
    }
    
}

$controllerFile = "Controller/".$controller.".class.php";
    
if(!file_exists($controllerFile)){

    die("Le controller ".$controllerFile." n'existe pas");

}

//Dans l'idée on doit faire un require parce vital au fonctionnement

//Mais comme on fait vérification avant du fichier le include est plus rapide a executer

include $controllerFile;



$controller = "App\\Controller\\".$controller;

if( !class_exists($controller)){

    die("La classe ".$controller." n'existe pas");

}
    
$objectController = new $controller();



if( !method_exists($objectController, $action)){

    die("L'action ".$action." n'existe pas");

}    


if (count($params)>0) {

    $objectController->$action($params);

}else{
    $objectController->$action();

}