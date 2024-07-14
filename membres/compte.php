<?php 

# Action
$action = $_POST["action"] ? $_POST["action"] : "consultation";

if ($action == "consultation") {

    $infos = getUserInfos($mysqli, $table_comediens, $membre['id']);
    $smarty->assign("infos", $infos);

}

$smarty->assign("action", $action);
