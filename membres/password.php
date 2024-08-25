<?php

$result = "changepassword";

if ($_POST["password"]) {

    if ($_POST["confirmpassword"] !== $_POST["password"]) {
        $result = "nomatch";
    } else {
        $update = updatePassword($mysqli, $table_comediens, $membre["id"], $_POST["password"], $salt);
        if ($update) {
            $result = "passwordchanged";
            setcookie('md5password', '', time()+60*60*24*365);
        } else {
            $result = "passwordnotchanged";
        }
    }
}

$smarty->assign("result", $result);
