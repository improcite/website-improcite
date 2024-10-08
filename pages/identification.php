<?php

session_start();

filter_var_array($_COOKIE, FILTER_SANITIZE_SPECIAL_CHARS);
filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$login = "";
$password = "";
$md5password = "";
$backURL = $_REQUEST['backURL'];
$decodedURL = $backURL ? base64_decode($backURL) : "membres/index.php";
$rememberme = 0;

$action = $_POST["action"] ? $_POST["action"] : "form";

if ($action == "form") {
    if (isset($_COOKIE['login']) && isset($_COOKIE['md5password'])) {
        $login = $_COOKIE['login'];
        $md5password = $_COOKIE['md5password'];
    }
}

if ($action == "login") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $rememberme = $_POST['rememberme'];
    $md5password = md5($salt.$password);
}

$auth = getUserWithPassword($mysqli, $table_comediens, $login, $md5password, $iCurrentSaisonNumber);

if ($auth && $auth["id"]) {
    $_SESSION[ "id_impro_membre" ] = $auth["id"];
    $_SESSION[ "prenom_impro_membre" ] = $auth["prenom"];
    $_SESSION[ "nom_impro_membre" ] = $auth["nom"];
    $_SESSION[ "rights_impro_membre" ] = $auth["rights"];
    if ($rememberme) {
        setcookie('login', $login, time()+60*60*24*365);
	    setcookie('md5password', $md5password, time()+60*60*24*365);
    }
    header("Location: $decodedURL");
} else if($login) {
    $smarty->assign('error','invalid_credentials');
    setcookie('login', '', time()+60*60*24*365);
    setcookie('md5password', '', time()+60*60*24*365);
}

$smarty->assign('action', $action);
$smarty->assign('backURL', $backURL);
