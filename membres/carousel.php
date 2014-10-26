<?php

include ( "../fonctions.inc.php" );
HandleAjaxFileUpload("image", "../photos/carousel/".getp("id").".jpg");

$CURRENT_MENU_ITEM = "caroussel";
include ( "tete.php" );
include ( "../fxFields.php" );

$dir = "../photos/carousel";
$files = scandir($dir);

$action = getp("action"); 
$admin = fxUserHasRight("admin");


if($action == "edit" && $admin)
{
	$sPhpFile = "<"."?"."php\n\n";
	$sPhpFile .= "$"."aCaroussel = array(";

	foreach($_POST as $k => $v)
	{
		if(strstr($k, ".")) continue;
		if($v == "active_on")
		{
			$sPhpFile .= '"'.$k.'",';
		}
	}
	$sPhpFile .= ");\n\n";
	$sPhpFile .= "?".">";
	file_put_contents( "../carousel.inc.php", $sPhpFile);
}
else
{
	$sPhpFile = file_get_contents("../carousel.inc.php");
}
?><ul class='list-group'><?

if($admin) {
?><form style="display:inline" action="?" method="post" role="form"><input type="hidden" name="action" value="edit"><?
}
foreach($files as $file)
{
	if($file == "." || $file == "..") continue;
	
	?><li class='list-group-item'><?
	
	$fileWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
	$bCheck = strstr($sPhpFile, '"'.$fileWithoutExt.'"');
	
	?><input type="checkbox" value="active_on" name="<?=$fileWithoutExt?>" <?=$bCheck?"CHECKED":""?> <?=$admin?"":"READONLY"?>>
	<img src="../photos/carousel/<?=$file?>" style="height:50px;" />
	</li><?
}

if($admin) {
?><input class="btn btn-primary" type="submit" value="Valider les modifications"/></form><?
}


?><li class='list-group-item'><?

$newId = time();
HandleAjaxFileUi("carousel.php", "image", $newId, "../photos/carousel/$newId", "Ajouter une image", "height:100px;", 800, 200, false);

?></li><?

?></ul><?

?>
