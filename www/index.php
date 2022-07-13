<?php

namespace App;

require "conf.inc.php";

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}


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

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

//Réussir à récupérer l'URI
$uri =  strtok($_SERVER["REQUEST_URI"], '?');


$routeFile = "routes.yml";
if(!file_exists($routeFile)){
    die("Le fichier ".$routeFile." n'existe pas");
}

$routes = yaml_parse_file($routeFile);

if( empty($routes[$uri]) ||  empty($routes[$uri]["controller"])  ||  empty($routes[$uri]["action"])){
    die("Erreur 404");
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

$controller = ucfirst(strtolower($routes[$uri]["controller"]));
$action = strtolower($routes[$uri]["action"]);
$params = isset($routes[$uri]["parameters"])?$routes[$uri]["parameters"]:false;


/*
 *
 *  Vérfification de la sécurité, est-ce que la route possède le paramètr security
 *  Si oui est-ce que l'utilisation a les droits et surtout est-ce qu'il est connecté ?
 *  Sinon rediriger vers la home ou la page de login
 *
 */


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
// $controller = User ou $controller = Global
$objectController = new $controller();

if( !method_exists($objectController, $action)){
    die("L'action ".$action." n'existe pas");
}
// $action = login ou logout ou register ou home

if ($params!=false) {
    $objectController->$action($params);
}else{
    $objectController->$action();
}