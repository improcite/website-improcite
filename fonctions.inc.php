<?php

#====================================================================
# Fonctions du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

/* ### Traitement du texte ### */ 

//error_reporting(E_ALL);
 
function getp($sName, $sDefault = "")
{
	// Post en 1er
	if (isset($_POST[$sName])) return $_POST[$sName];
	if (isset($_GET[$sName])) return $_GET[$sName];
	return $sDefault;
}


function dateToUnix($date)
{
	preg_match( "~([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})~" , $date , $tableau );
	return mktime($tableau[4], $tableau[5], $tableau[6], $tableau[2], $tableau[3], $tableau[1]);
}

function unixToDate($iTime)
{
	return date("YmdHis", $iTime);
}

function isPrintMode()
{
	return getp("printmode")==1;
}

function DisplayPrintButton()
{
	if (! isPrintMode())
	{
		$sURI = $_SERVER['REQUEST_URI'];
		if (strpos("?", $sURI)===false) $sURI .= "?"; else $sURI .= "&";
		echo "<a style=\"float:right;\" class=\"btn btn-primary\" role=\"button\" target=\"_new\" href=\"".$sURI."printmode=1\"><i class=\"glyphicon glyphicon-print\"></i> Imprimer cette page</a>";
	}
}


function get_photo_uri($id = 0)
{
	if($id == 0)
	{
		$id = $_SESSION['id_impro_membre'];
	}
	
	global $sPhotoRelDir;
	global $currentSaisonBit;
	
	$photo = $sPhotoRelDir.$currentSaisonBit."/"."$id.jpg" ;
	if ( !file_exists( dirname(__FILE__)."/".$photo ) ) {
		$photo = $sPhotoRelDir."$id.jpg" ;
	}
	
	if ( !file_exists( dirname(__FILE__)."/".$photo ) ) {
		$photo = $sPhotoRelDir."defaut.jpg";
	}	
	
	return str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__)."/".$photo);
}



function image_resize_crop($src, $dst, $width, $height, $crop=0){

  if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";

  $type = strtolower(substr(strrchr($src,"."),1));
  if($type == 'jpeg') $type = 'jpg';
  switch($type){
    case 'bmp': $img = imagecreatefromwbmp($src); break;
    case 'gif': $img = imagecreatefromgif($src); break;
    case 'jpg': $img = imagecreatefromjpeg($src); break;
    case 'png': $img = imagecreatefrompng($src); break;
    default : return "Unsupported picture type!";
  }

  // resize
  if($crop){
    if($w < $width or $h < $height) return "Picture is too small!";
    $ratio = max($width/$w, $height/$h);
    $h = $height / $ratio;
    $x = ($w - $width / $ratio) / 2;
    $w = $width / $ratio;
  }
  else{
    if($w < $width and $h < $height) return "Picture is too small!";
    $ratio = min($width/$w, $height/$h);
    $width = $w * $ratio;
    $height = $h * $ratio;
    $x = 0;
  }

  $new = imagecreatetruecolor($width, $height);

  // preserve transparency
  if($type == "gif" or $type == "png"){
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, true);
  }

  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

  switch($type){
    case 'bmp': imagewbmp($new, $dst); break;
    case 'gif': imagegif($new, $dst); break;
    case 'jpg': imagejpeg($new, $dst); break;
    case 'png': imagepng($new, $dst); break;
  }
  return true;
}


function extract_month( $date)
{
	if ( preg_match ( "~([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})~" , $date , $tableau )  )
	{
		return $tableau[2];
	}
	return false;
}

function extract_year( $date)
{
	if ( preg_match ( "~([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})~" , $date , $tableau )  )
	{
		return $tableau[1];
	}
	return false;
}


 
function affiche_date ( $date ) {

	# La date doit etre de la forme AAAAMMJJhhmmss

	if ( preg_match( "~([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})~" , $date , $tableau )  ) {

		$aMois = array(
			'janvier',
			'f&eacute;vrier',
			'mars',
			'avril',
			'mai',
			'juin',
			'juillet',
			'ao&ucirc;t',
			'septembre',
			'octobre',
			'novembre',
			'd&eacute;cembre'
		);
		
		$aJours = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
		
		$iJourSemaine =  date("w", mktime(12, 00, 00, $tableau[2], $tableau[3], $tableau[1]));
		$sNomJour = $aJours[$iJourSemaine];

		$jour = number_format($tableau[3],0);
		$iMois = number_format($tableau[2], 0) - 1;
		$sMois = $aMois[$iMois];
		$sAnnee = $tableau[1];
		
		//echo $iJourSemaine;
		//print_r( $tableau );
		
		return "$sNomJour $jour $sMois $sAnnee" ;
	}

}

function affiche_heure ( $date ) {

	# La date doit etre de la forme AAAAMMJJhhmmss

	if ( preg_match ( "~([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})~" , $date , $tableau )  ) {
	
		$heure = number_format($tableau[4],0);
		return "${heure}h$tableau[5]" ;

	}
}

function affiche_texte ( $texte ) {

	/* Prends le texte et y ajoute des hyperliens sur les emails et les sites */

	if ( empty ( $texte ) )
	{
		return $texte ;
	}
	
	/* Gere les HTML entities */

	//$texte = htmlentities ( $texte ) ;

	$lines = explode ("\n", $texte) ;
	
	while (list ($key, $line) = each ($lines)) {

		$line = preg_replace("~([ \t]|^)www\.~i", " http://www.", $line);
		$line = preg_replace("~([ \t]|^)ftp\.~i", " ftp://ftp.", $line);
		$line = preg_replace("~[^\"'=](http://[^ )\r\n]+)~i", "<a target=\"_new\" href=\"\\1\" title=\"\\1\">\\1</a>", $line);
		$line = preg_replace("~[^\"'=](https://[^ )\r\n]+)~i", "<a target=\"_new\" href=\"\\1\" title=\"\\1\">\\1</a>", $line);
		$line = preg_replace("~[^=\"'](ftp://[^ )\r\n]+)~i", "<a target=\"_new\" href=\"\\1\" title=\"\\1\">\\1</a>", $line);
		$line = preg_replace("~([-a-z0-9_]+(\.[_a-z0-9-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)+))~i", "<a href=\"mailto:\\1\">\\1</a>", $line);

		if ( empty ( $newText ) ) {
		
			$newText = $line;
		}

		else {

			$newText .= "\n$line" ;
		}
		
	}

	/* Transforme les \n en <br /> */

	$data = str_replace (chr(13).chr(10), "<br />", $newText) ;
	
	return $data ;

}

function bouton_menu ( $nom , $lien , $commentaire ) {

	/* genere la balise img avec l'appel au javascript pour changer l'image quand la souris passe dessus */

	/* Si IE, on fait du non XHTML :( */
	
	$js_fonction = "swapImage" ;

	$a_tag = "<a href=\"$lien\" title=\"$commentaire\" onmouseover=\"$js_fonction('$nom','images/bouton_${nom}_on.gif')\" onmouseout=\"$js_fonction('$nom','images/bouton_${nom}_off.gif')\">\n" ;
	
	$img_tag = "\t<img src=\"images/bouton_${nom}_off.gif\" alt=\"$nom\" " ;
	
	if ( msie() ) { $img_tag.="name" ; } else { $img_tag.="id" ; }
	
	$img_tag.="=\"$nom\" />\n" ;

	return $a_tag.$img_tag."</a>\n" ;

}

function msie ( ) {

	/* Renvoie 1 si le navigateur est Internet Explorer de Microsoft */

	$test = 0 ;

	if ( preg_match('~MSIE~', $_SERVER["HTTP_USER_AGENT"]) && !preg_match('~Opera~', $_SERVER["HTTP_USER_AGENT"]) ) {

		$test = 1 ;

	}

	return $test ;

}




function fix_magic_quotes ($var = NULL, $sybase = NULL)
{
  // si $sybase n'est pas sp�cifi�, on regarde la configuration ini
  if ( !isset ($sybase) )
  {
    $sybase = ini_get ('magic_quotes_sybase');
  }

  // si $var n'est pas sp�cifi�, on corrige toutes les variables superglobales
  if ( !isset ($var) )
  {
    // si les magic_quotes sont activ�es
    if ( get_magic_quotes_gpc () )
    {
      // tableaux superglobaux a corriger
      $array = array ('_REQUEST', '_GET', '_POST', '_COOKIE');
      if ( substr (PHP_VERSION, 0, 1) <= 4 )
      {
        // PHP5 semble ne pas changer _ENV et _SERVER
        array_push ($array, '_ENV', '_SERVER');
        // les magic_quotes ne changent pas $_SERVER['argv']
        $argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : NULL;        
      }
      foreach ( $array as $var )
      {
        $GLOBALS[$var] = fix_magic_quotes ($GLOBALS[$var], $sybase);
      }
      if ( isset ($argv) )
      {
        $_SERVER['argv'] = $argv;
      }
      // d�sactive les magic quotes dans ini_set pour que les 
      // scripts qui y sont sensibles fonctionnent
      ini_set ('magic_quotes_gpc', 0);
    }

    // idem, pour magic_quotes_sybase
    if ( $sybase )
    {
      ini_set ('magic_quotes_sybase', 0);
    }

    // d�sactive magic_quotes_runtime
    set_magic_quotes_runtime (0);
    return TRUE;
  }

  // si $var est un tableau, appel r�cursif pour corriger chaque �l�ment
  if ( is_array ($var) )
  {
    foreach ( $var as $key => $val )
    {
      $var[$key] = fix_magic_quotes ($val, $sybase);
    }

    return $var;
  }

  // si $var est une chaine on utilise la fonction stripslashes,
  // sauf si les magic_quotes_sybase sont activ�es, dans ce cas on 
  // remplace les doubles apostrophes par des simples apostrophes
  if ( is_string ($var) )
  {
    return $sybase ? str_replace ('\'\'', '\'', $var) : stripslashes ($var);
  }

  // sinon rien
  return $var;
}

class iCal
{
	function iCalDecoder($file)
	{
		$ical = utf8_decode(file_get_contents($file));
		preg_match_all('~(BEGIN:VEVENT.*?END:VEVENT)~si', $ical, $result, PREG_PATTERN_ORDER);
		for ($i = 0; $i < count($result[0]); $i++)
		{
			$tmpbyline = explode("\r\n", $result[0][$i]);
			foreach ($tmpbyline as $item)
			{
				$tmpholderarray = explode(":",$item);
				if (count($tmpholderarray) >1)
				{
					$filtered = preg_replace("~;.*~", "", $tmpholderarray[0]);
					$majorarray[$filtered] = $tmpholderarray[1];
				}
			}
			//if (preg_match('/DESCRIPTION:(.*)END:VEVENT/si', $result[0][$i], $regs))
			//{	$majorarray['DESCRIPTION'] = str_replace("  ", " ", str_replace("\r\n", "", $regs[1]));	}
			
			$icalarray[] = $majorarray;
			unset($majorarray);
		}
		return $icalarray;
	}
}

function afficher_inscription_newsletter($sEmail = "")
{

	echo '<form action="http://groups.google.com/group/improcite-infos/boxsubscribe">';
	echo 'Email&nbsp;: <input type="text" name="email" size="40" value="'.$sEmail.'">';
	echo '&nbsp;<input type=submit name="sub" value="S&#39;inscrire"><div style="font-size:50%;vertical-align:super;">* Un email par mois environ. votre email ne sera jamais vendu ni partag�. Vous pourrez vous d�-inscrire a tout moment.</div>';
	echo '</form>';
}

?>
