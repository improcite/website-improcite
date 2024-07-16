<?php

$action = $_GET["action"] ? $_GET["action"] : "consultation";

$smarty->assign("action", $action);
$smarty->assign("airtables_form_url", $airtables_form_url);
$smarty->assign("airtables_cards_url", $airtables_cards_url);
