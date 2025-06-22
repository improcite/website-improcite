<?php

#====================================================================
# Configuration du site Improcite
# 2004 (c) Clement OUDOT
#====================================================================

/* Debug */
$debug = 0;

/* Connexion */
include_once("secrets.inc.php");

/* Indicatif de la saison */
// 0 = 2004-2005
// 1 = 2005-2006
// 2 = 2006-2007
// 3 = 2007-2008
// 4 = 2008-2009
// 5 = 2009-2010
// 6 = 2010-2011
// 7 = 2011-2012
// 8 = 2012-2013
// 9 = 2013-2014
// 10 = 2014-2015
// 11 = 2015-2016
// 12 = 2016-2017
// 13 = 2017-2018
// 14 = 2018-2019
// 15 = 2019-2020
// 16 = 2020-2021
// 17 = 2021-2022
// 18 = 2022-2023
// 19 = 2023-2024
// 20 = 2024-2025
// 21 = 2025-2026
$iCurrentSaisonNumber = 20;

/* Nb de spectacles affiches sur la page de bienvenue */
$nb_spectacles_welcome = 2;

/* Chemin relatif pour trouver les photos */
$sPhotoRelDir = "photos/comediens/";
$sPhotoLieuRelDir = "photos/lieux/";
$sPhotoIntervenantsRelDir = "photos/intervenants/";
$sPhotoEvenement = "photos/evenements/";
$sPhotoCategorie = "photos/categories/";

/* Afficher la page recrutement sur la partie publique */
$display_recrutement_public = 1;
/* Afficher la page recrutement sur la partie privée */
$display_recrutement_private = 1;
/* Saison concernée par le recrutement et dates */
$saison_recrutement = 21;
$dates_recrutement = ['Jeudi 4 septembre 2025 à 20h', 'Jeudi 11 septembre 2025 à 20h'];

# Nom de la base MySQL
$base = "improcite" ;

/* ### Noms des tables ### */

# Table contenant la liste des comediens
$table_comediens = "impro_comediens" ;

# Table contenant la liste des evenements
$t_eve = "impro_evenements" ;

# Table contenant la liste des categories des evenements
$t_cat = "impro_categories_evenements" ;

# Table contenant la liste des liens
$table_liens = "impro_liens" ;

# Table contenant la liste des reservations
$t_res = "impro_reservations" ;

# Table contenant la liste des lieux
$t_lieu = "impro_lieux" ;

# Table questionnaire recrutement
$t_recrutement = "impro_recrutement";

# Airtables URL
$airtables_cards_url = "https://airtable.com/embed/".$airtables_cards."?backgroundColor=blue&viewControls=on";
$airtables_form_url = "https://airtable.com/embed/".$airtables_form."?backgroundColor=blue";

# Box URL
$box_token_url = 'https://api.box.com/oauth2/token';

if ($debug)
{
	error_reporting(E_ALL);
}
else
{
	error_reporting(0);
}

# Timezone
$date_timezone = "Europe/Paris";

?>
