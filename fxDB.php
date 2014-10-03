<?php

function getIcon($sType)
{
	$h = 16;
	if ($sType=="pen") return "<img border=0 height=$h align=absmiddle src=\"img/pencil.gif\" />";
	if ($sType=="delete") return "<img border=0 height=$h align=absmiddle src=\"img/delete.gif\" />";
	if ($sType=="add") return "<img border=0 height=$h align=absmiddle src=\"img/add.gif\" />";
}

function fxQuery( $sSQL, $aParams = array() )
{
	if (!is_array($aParams))
	{		// 1 seul param
		$aParams = array($aParams);
	}
	
	if (false !== strpos($sSQL, "?"))
	{
		$aSQL = explode("?", $sSQL);
		$sSQL = "";
		for($i=0;$i<sizeof($aSQL)-1;$i++)
		{
			$sSQL .= $aSQL[$i]."'".mysql_real_escape_string($aParams[$i])."'";
		}
		$sSQL .= $aSQL[sizeof($aSQL)-1];
	}
	
	//////////echo $sSQL;
	
	$oRet = mysql_query ( $sSQL );
	if (!$oRet)
	{
		die("Erreur MySQL sur \"".$sSQL."\" : \"".mysql_error()."\"");
	}
	return $oRet;
}

function fxFetch(&$aRq)
{
	return @mysql_fetch_array($aRq);
}


function fxExtractRow(&$aRow)
{
	foreach($aRow as $k=>$v)
	{
		if (is_numeric($k)) continue;
		global $$k;
		$$k = $v;
	}
}

function fxQuerySingleValue( $sSQL, $aParams = array() )
{
	$r = @mysql_fetch_array(fxQuery($sSQL, $aParams), MYSQL_NUM);
	return $r[0];
}

function fxQueryMultiValues( $sSQL, $aParams = array() )
{
	return @mysql_fetch_array(fxQuery($sSQL, $aParams), MYSQL_NUM);
}

function fxQueryIndexedAsSelect( $sSQL, $aParams, $sName, $sSelected = "", $bEmpty = false, $bReadOnly = false )
{
	$sOut = "<SELECT id=$sName name=$sName ".($bReadOnly ? "DISABLED":"").">\n";
	$rq = fxQuery( $sSQL, $aParams );
	
	if ($bEmpty)
	{
		$sSel = $sSelected == "" ? " SELECTED":"";
		$sOut.= "<OPTION $sSel></OPTION>";
	}
	
	while ( $row = @mysql_fetch_array ( $rq, MYSQL_NUM ) )
	{
		$sSel = $row[0]==$sSelected ? " SELECTED":"";
		$sOut.= "<OPTION $sSel value={$row[0]}>{$row[1]}</OPTION>";
	}
	$sOut .= "</SELECT>\n";
	return $sOut;
}


function fxQueryIndexed( $sSQL, $aParams= array() )
{
	$aOut = array();
	$rq = fxQuery( $sSQL, $aParams );
	while ( $row = @mysql_fetch_array ( $rq, MYSQL_NUM ) )
	{
		$aOut[$row[0]] = $row[1];
	}
	return $aOut;
}

function fxQueryIndexedRow( $sSQL, $aParams= array() )
{
	$aOut = array();
	$rq = fxQuery( $sSQL, $aParams );
	while ( $row = @mysql_fetch_array ( $rq, MYSQL_ASSOC ) )
	{
		$aOut[$row[0]] = $row;
	}
	return $aOut;
}

function fxQueryReplace($sTable, $aFieldsAndValues)
{
	$aParams = array();

	$sSQL1 = "REPLACE INTO $sTable (";
	$sSQL2 = " VALUES (";
	foreach($aFieldsAndValues as $k => $v)
	{
		$aParams[] = $v;
		$sSQL1 .= "$k,";
		$sSQL2 .= "?,";
	}
	$sSQL1 = trim($sSQL1, ",").")";
	$sSQL2 = trim($sSQL2, ",").")";
	
	fxQuery($sSQL1.$sSQL2, $aParams);
}



function fxQueryInsert($sTable, $aFieldsAndValues)
{
	$aParams = array();

	$sSQL1 = "INSERT INTO $sTable (";
	$sSQL2 = " VALUES (";
	foreach($aFieldsAndValues as $k => $v)
	{
		$aParams[] = $v;
		$sSQL1 .= "$k,";
		$sSQL2 .= "?,";
	}
	$sSQL1 = trim($sSQL1, ",").")";
	$sSQL2 = trim($sSQL2, ",").")";
	
	fxQuery($sSQL1.$sSQL2, $aParams);
}

function fxQueryUpdate($sTable, $aFieldsAndValues, $lineId)
{

	$aParams = array();

	$sSQL1 = "UPDATE $sTable SET ";
	foreach($aFieldsAndValues as $k => $v)
	{
		$aParams[] = $v;
		$sSQL1 .= "$k=?,";
	}
	$sSQL1 = trim($sSQL1, ","); // virer la virgule
	$aParams[] = $lineId;
	$sSQL1 .= " WHERE id = ?";
	
	fxQuery($sSQL1, $aParams);
}


function fxDispRequest($sSQL, $sDeleteURL="", $sUpdURL="")
{
	$rq = @mysql_query ( $sSQL );
	$bFisrst = true;
	echo "\n<table border=1 cellpadding=2 cellspacing=0 bordercolor=black>\n";
	while ( $row = @mysql_fetch_array ( $rq ) )
	{
		if ($bFisrst)
		{
			$bFisrst = false;
			echo "<tr bgcolor=#888888>";
			if ($sDeleteURL) echo "<td></td>";
			if ($sUpdURL) echo "<td></td>";
			foreach($row as $k=>$v)
			{
				if (is_numeric($k)) continue;
				$k = strtoupper(substr($k,0,1)).substr($k,1);
				echo "<td valign=top>$k</td>";
			}
			echo "</tr>";
		}
		echo "<tr";
		if (isset($row["id"])  &&  isset($_GET["id"])  &&  $_GET["id"] == $row["id"]) echo " bgcolor=#FF8888";
		echo ">";
		if ($sDeleteURL) echo "<td><a href=\"?$sDeleteURL&id=".$row['id']."\" onClick=\"return confirm('Effacer?');\">".getIcon('delete')."</a></td>";
		if ($sUpdURL) echo "<td><a href=\"?$sUpdURL&id=".$row['id']."\");\">".getIcon('pen')."</a></td>";
		foreach($row as $k=>$v)
		{
			if ($k=="date") $v = affiche_date($v);
			if ($k=="password") $v = preg_replace("~.~","*",$v);
			if (is_numeric($k)) continue;
			if (!$v) $v = "&nbsp;";
			$v = preg_replace("~<.*?>~","",$v);
			if (!isPrintMode()  &&  strlen($v)>30) $v = substr($v,0,30)."(...)";
			echo "<td valign=top>$v</td>";
		}
		echo "</tr>\n";
	}
	echo "</table>";
}

?>
