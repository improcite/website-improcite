<?php

$result = "changepassword";

if ($_POST["password"]) {

    if ($_POST["confirmpassword"] !== $_POST["password"]) {
        $result = "nomatch";
    } else {
        $update = updatePassword($mysqli, $table_comediens, $membre["id"], $_POST["password"], $salt);
        if ($update) {
            $result = "passwordchanged";
        } else {
            $result = "passwordnotchanged";
        }
    }
}

$smarty->assign("result", $result);
