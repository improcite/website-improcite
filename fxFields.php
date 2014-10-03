<?php
function fxFieldsInit($bEnableRichEdit)
{
	?>
	<script type="text/javascript" src="nicEdit.js"></script>
	<script type="text/javascript">
		<? if ($bEnableRichEdit) { ?>
		bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
		<? } ?>
	</script>
	<script type="text/javascript">
	function buildDt(id)
	{
		document.getElementById("fld_"+id).value =
			document.getElementById("dt1"+id).value+
			document.getElementById("dt2"+id).value+
			document.getElementById("dt3"+id).value+
			document.getElementById("dt4"+id).value+
			document.getElementById("dt5"+id).value+
			document.getElementById("dt6"+id).value;
			
		myDays=["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];
		myDate=new Date(document.getElementById("dt1"+id).value, (0+document.getElementById("dt2"+id).value)-1, document.getElementById("dt3"+id).value)
		document.getElementById("dtDay"+id).innerHTML = myDays[myDate.getDay()];
	}
	function buildBitValue(id, nbbits)
	{
		var val = 0;
		for(i=0;i<nbbits;i++)
		{
			var fieldName = "bitfield_"+id+"_"+i;
			if (document.getElementById(fieldName).checked)
			{
				val = val | (1<<i);
			}
		}
		document.getElementById("fld_"+id).value = val;
	}
	</script>
	<?
}

function fxDispFields(&$aData)
{
	global $fxH_do;
	global $fxH_tbl_edit_id;
	global $fxH_tbl_name;

	$aFields = &$aData['fields'];
	
	if ($fxH_do == "edit"  ||  $fxH_do == "add")
	{
		?>
		<form method="post">
		<input type=hidden name="do" value="addOrUpdate">
		<table border=0>
		<?
		foreach($aFields as $aField)
		{
			$aTxt = explode("|", $aField[0]);
			echo "<tr><td valign=top align=right style=\"background-color:#888\">";
			echo $aTxt[0];
			echo ": </td><td valign=top>";
			
			$bEditable = isset($aField[4]) ? $aField[4] : true;
			$id = $aField[2];
			$aTypeInfos = explode("|", $aField[1]);
			$aTypeInfo = $aTypeInfos[0];
			$disabledTxt = $bEditable ? "" : "DISABLED style=\"background-color:#D4D0C8;color:#808080;\"";
			switch($aTypeInfo)
			{
				case "text":
					?><input <?=$disabledTxt?> size="30" name="fld_<?=$aField[2]?>" value="<?=fxPreFill($aField[2], $aField[3])?>"><?
				break;

				case "password":
					?><input <?=$disabledTxt?> size="30" type="password" name="fld_<?=$aField[2]?>" value="<?=fxPreFill($aField[2], $aField[3])?>"><?
				break;	
				
				case "memo":
					?><textarea <?=$disabledTxt?> cols="100" rows="5" name="fld_<?=$aField[2]?>"><?=fxPreFill($aField[2], $aField[3])?></textarea><?
				break;
				
				case "date":
					$sDef = fxPreFill($aField[2], $aField[3]);
					$sDef1 = substr($sDef, 0,4);
					$sDef2 = substr($sDef, 4,2);
					$sDef3 = substr($sDef, 6,2);
					$sDef4 = substr($sDef, 8,2);
					$sDef5 = substr($sDef, 10,2);
					$sDef6 = substr($sDef, 12,2);
					?><input type="hidden" id="fld_<?=$id?>" name="fld_<?=$id?>" value="<?=fxPreFill($aField[2], $aField[3])?>">
					
					<div style="display:inline;" id="dtDay<?=$id?>"></div>&nbsp;
					
					<select <?=$disabledTxt?> id="dt3<?=$id?>" onChange="buildDt('<?=$id?>')">
					<?for($i=0;$i<=31;$i++) { ?><option value="<?=sprintf("%02d", $i)?>" <?=$sDef3==$i?"SELECTED":""?>><?=sprintf("%02d", $i)?></option><? } ?>
					</select>
					
					<select <?=$disabledTxt?> id="dt2<?=$id?>" onChange="buildDt('<?=$id?>')">
					<option value="01" <?=$sDef2=="01"?"SELECTED":""?>>Jan</option>
					<option value="02" <?=$sDef2=="02"?"SELECTED":""?>>Fev</option>
					<option value="03" <?=$sDef2=="03"?"SELECTED":""?>>Mar</option>
					<option value="04" <?=$sDef2=="04"?"SELECTED":""?>>Avr</option>
					<option value="05" <?=$sDef2=="05"?"SELECTED":""?>>Mai</option>
					<option value="06" <?=$sDef2=="06"?"SELECTED":""?>>Jun</option>
					<option value="07" <?=$sDef2=="07"?"SELECTED":""?>>Jul</option>
					<option value="08" <?=$sDef2=="08"?"SELECTED":""?>>Aou</option>
					<option value="09" <?=$sDef2=="09"?"SELECTED":""?>>Sep</option>
					<option value="10" <?=$sDef2=="10"?"SELECTED":""?>>Oct</option>
					<option value="11" <?=$sDef2=="11"?"SELECTED":""?>>Nov</option>
					<option value="12" <?=$sDef2=="12"?"SELECTED":""?>>Dec</option>
					</select>
					
					<select <?=$disabledTxt?> id="dt1<?=$id?>" onChange="buildDt('<?=$id?>')">
					<?for($i=2000;$i<date("Y")+2;$i++) { ?><option value="<?=$i?>" <?=$sDef1==$i?"SELECTED":""?>><?=$i?></option><? } ?>
					</select>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select <?=$disabledTxt?> id="dt4<?=$id?>" onChange="buildDt('<?=$id?>')">
					<?for($i=0;$i<24;$i++) { ?><option value="<?=sprintf("%02d", $i)?>" <?=$sDef4==$i?"SELECTED":""?>><?=sprintf("%02d", $i)?></option><? } ?>
					</select>h

					<select <?=$disabledTxt?> id="dt5<?=$id?>" onChange="buildDt('<?=$id?>')">
					<?for($i=0;$i<60;$i+=5) { ?><option value="<?=sprintf("%02d", $i)?>" <?=$sDef5==$i?"SELECTED":""?>><?=sprintf("%02d", $i)?></option><? } ?>
					</select>mn

					<input type="hidden" id="dt6<?=$id?>" size="2" value="<?=$sDef6?>" onChange="buildDt('<?=$id?>')">
					
					<script>buildDt('<?=$id?>');</script>
					
					
					<?
				break;
				
				case "check":
					?><input <?=$disabledTxt?> type="radio" value="1" name="fld_<?=$aField[2]?>" <?=fxPreFill($aField[2],$aField[3])?"CHECKED":""?>>Oui <input <?=$disabledTxt?> type="radio" value="0" name="fld_<?=$aField[2]?>" <?=(!fxPreFill($aField[2],$aField[3]))?"CHECKED":""?>>Non<?
				break;
				
				case "list":
					echo "<select $disabledTxt name=\"fld_".$aField[2]."\">";
					foreach(explode(",", $aTypeInfos[1]) as $v)
					{
						$k = $v;
						echo "<option value=\"{$k}\" ";
						if ($k == fxPreFill($aField[2],$aField[3])) echo " SELECTED ";
						echo ">$v</option>";
					}
					echo "</select>";
				break;						
				
				
				case "otherlist":
					echo fxQueryIndexedAsSelect("SELECT ".$aTypeInfos[2].", ".$aTypeInfos[3]." AS n FROM ".$aTypeInfos[1]." ORDER BY n", array(), "fld_".$aField[2], fxPreFill($aField[2],$aField[3]), true, !$bEditable);
				break;	
				
				case "bitfield":
					$iBit = 0;
					$value = fxPreFill($aField[2], $aField[3]);
					$aLabels = explode(",", $aTypeInfos[1]);
					$iNbBits = sizeof($aLabels);
					foreach($aLabels as $v)
					{
						$check = (($value & (1<<$iBit)) != 0) ? "CHECKED" : "";
						$fldName = "bitfield_".$aField[2]."_".$iBit;
						?><?=$v?><input <?=$disabledTxt?> type="checkbox" name="<?=$fldName?>" id="<?=$fldName?>" onClick="buildBitValue('<?=$aField[2]?>', <?=$iNbBits?>);" <?=$check?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?
						$iBit++;
					}
					?><input type="hidden" name="fld_<?=$aField[2]?>" id="fld_<?=$aField[2]?>" value="<?=fxPreFill($aField[2], $aField[3])?>" ><?
				break;		
				
				default:
					?>???<?
				break;
			}
			if (isset($aTxt[1])) echo $aTxt[1];
			echo "</td></tr>\n\n";
		}
		echo "</table>\n";
		?>
		<input type=hidden name="tbl_name" value="<?=$aData['table']?>">
		<input type="submit" value="Ajouter/Mettre à jour" onClick="return confirm('Etes-vous sur ?');">
		 (Mettre à jour le n° <?=fxQueryIndexedAsSelect("SELECT id, id FROM ".$aData['table']." ORDER BY id", array(), "tbl_replace_id", $fxH_tbl_edit_id, true);?>)
		</form>
		<br>
		<br>
		<div style="border-bottom:1px solid black;width:100%;"></div>
		<?
	}
	else
	{
		?><a href="?tbl_name=<?=$aData['table']?>&do=add"><?=getIcon('add')?> Ajouter</a><br><?
	} // edit/add
}

function fxPreFill($sField, $sDefault = "")
{
	global $fxH_aPreFill;
	if (isset($fxH_aPreFill[$sField])) return $fxH_aPreFill[$sField]; else return $sDefault;
}

function fxHandleRequests()
{
	global $fxH_do;
	global $fxH_tbl_edit_id;
	global $fxH_tbl_name;
	global $fxH_aPreFill;
	
	//---------------------------------------------------------------------------
	// Exécution des éventuelles requêtes d'ajout, modification ou suppression
	// des tables gérées.
	//---------------------------------------------------------------------------
	$fxH_do =getp("do");
	$fxH_tbl_name = getp("tbl_name");
	$tbl_replace_id = getp("tbl_replace_id");
	$fxH_tbl_edit_id = ($fxH_do=="edit") ? getp("id") : "";
	$fxH_aPreFill = array();
	
	
	if ($fxH_tbl_edit_id  &&  $fxH_tbl_name)
	{
		$rq = fxQuery( "SELECT * FROM $fxH_tbl_name WHERE id=?", $fxH_tbl_edit_id );
		$fxH_aPreFill = @mysql_fetch_array( $rq, MYSQL_ASSOC );
	}
	
	$aAutoParams = array();
	foreach($_REQUEST as $k => $v)
	{
		$k2 = preg_replace("~^fld_~", "", $k);
		if ($k != $k2)
		{
			$aAutoParams[$k2] = $v;
		}
	}
	
	if ($fxH_do == "addOrUpdate"  &&  $fxH_tbl_name)
	{
		if ($tbl_replace_id)
		{
			fxQueryUpdate($fxH_tbl_name, $aAutoParams, $tbl_replace_id);
		}
		else
		{
			fxQueryInsert($fxH_tbl_name, $aAutoParams);
		}
	}
	else if ($fxH_do == "delete"  &&  $fxH_tbl_name)
	{
		fxQuery("DELETE FROM $fxH_tbl_name WHERE id=?", $_REQUEST["id"]);
	}
}



?>
