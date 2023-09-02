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
$iCurrentSaisonNumber = 19;

/* La même chose, mais en puissance de 2*/
// 1 = 2004-2005
// 2 = 2005-2006
// 4 = 2006-2007
// 8 = 2007-2008
// 16 = 2008-2009
// 32 = 2009-2010
// 64 = 2010-2011
// 128 = 2011-2012
// 256 = 2012-2013
// 512 = 2013-2014
// 1024 = 2014-2015
// 2048 = 2015-2016
// 4096 = 2016-2017
// 8192 = 2017-2018
// 16384 = 2018-2019
// 32768 = 2019-2020
// 65536 = 2020-2021
// 131072 = 2021-2022
// 262144 = 2022-2023
// 524288 = 2023-2023
$currentSaisonBit = 524288;

/* Utilisé pour afficher le champ ds l'admin */
$saisonAdminString = "2004-2005,2005-2006,2006-2007,2007-2008,2008-2009,2009-2010,2010-2011,2011-2012,2012-2013,2013-2014,2014-2015,2015-2016,2016-2017,2017-2018,2018-2019,2019-2020,2020-2021,2021-2022,2022-2023,2023-2024";

/* Numero de categorie pour les entrainements */
$category_train = 1;

/* Numero de categorie OMERTA */
$category_omerta = 4;

/* Nb de spectacles affiches sur la page de bienvenue */
$nb_spectacles_welcome = 2;

/* Chemin relatif pour trouver les photos */
$sPhotoRelDir = "photos/comediens/";
$sPhotoLieuRelDir = "photos/lieux/";
$sPhotoIntervenantsRelDir = "photos/intervenants/";
$sPhotoEvenement = "photos/evenements/";
$sPhotoCategorie = "photos/categories/";
$sPhotoOmerta = "photos/omerta/";

# Nom de la base MySQL
$base = "improcite" ;

/* ### Noms des tables ### */

# Table contenant la liste des comediens
$table_comediens = "impro_comediens" ;

# Table contenant les news apparaissant en premiere page
$table_news = "impro_news" ;

# Table contenant la liste des membres du Fan Club
$table_fanclub = "impro_tamere" ;

# Table contenant la liste des evenements
$t_eve = "impro_evenements" ;

# Table contenant la liste des categories des evenements
$t_cat = "impro_categories_evenements" ;

# Table contenant la liste des intervenants
$table_intervenants = "impro_intervenants" ;

# Table contenant la liste des liens
$table_liens = "impro_liens" ;

# Table contenant la liste des boulettes et autres
$t_nq = "impro_nimportequoi" ;

# Table contenant la liste des reservations
$t_res = "impro_reservations" ;

# Table contenant la liste des inscrits a la lettre d'informations
$t_lettre = "impro_newsletter" ;

# Table contenant la liste des lieux
$t_lieu = "impro_lieux" ;

# Table omerta
$t_omerta = "impro_omerta";

# Table liens entre spectacle omerta, comedien et personnage omerta
$t_omerta_comediens = "impro_omerta_comediens";

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


?>
