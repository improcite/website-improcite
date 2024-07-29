<?php

if (!$membre["isAdmin"]) {
    header('location: /membres/'); exit;
}

# Action
$action = $_REQUEST["action"] ? $_REQUEST["action"] : "consultation";

if ($action == "consultation") {

    $result = getAllObjects($mysqli, $t_cat);
    $categories = [];
    foreach ($result as $row) {
        $row["photo"] = getPhotoCategorie($row["id"], "..");
        $categories[] = $row;
    }
    $smarty->assign("categories", $categories);

}

$smarty->assign("action", $action);

