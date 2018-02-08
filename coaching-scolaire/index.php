<?php
include "config.php";
// utilisation du MVC --> pour chaque vue, besoin d'un controller ! (même s'il est vide)

$page = "home"; //default page


//la page désirée est affichée
if(array_key_exists('page', $_GET)) {
    $page = $_GET['page'];
}

// si la page désirée est introuvable ou n'existe pas, on affiche une page d'erreur
if(!file_exists("www/$page.phtml") AND !file_exists("www/$page/$page.phtml")) {
    $page = "erreur";
}

//charge automatiquement les classes et controllers



$userSession = new UserSession();
$controllerName = $page."Controller";
$controller = new $controllerName;

if(!empty($_POST)){
    $result = $controller->httpPostMethod($_POST);
    extract($result);
}
if(!empty($_GET)){
    $result = $controller->httpGetMethod($_GET);
    extract($result);
}

//chargement des vues
include "www/layout.phtml";
