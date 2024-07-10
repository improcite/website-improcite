<?php

function getPhotoEvenement($id_evenement, $id_lieu, $id_categorie) {

    $photo = "/assets/images/photo_spectacle_defaut.jpg";
    $photoEvenement = "/photos/evemenents/".$id_evenement.".jpg";
    $photoLieu = "/photos/lieux/".$id_lieu.".jpg";
    $photoCategorie = "/photos/categories/".$id_categorie.".jpg";

    if (file_exists(".$photoLieu")) { $photo = $photoLieu; }
    if (file_exists(".$photoCategorie")) { $photo = $photoCategorie; }
    if (file_exists(".$photoEvenement")) { $photo = $photoEvenement; }

    return $photo;
}

function getPhotoMembre($id_membre, $id_saison, $path) {

    $path = $path ? $path : ".";
    $photo = "/assets/images/photo_membre_defaut.jpg";

    $bit_saison = pow(2,intval($id_saison));
    $photoSaison = "/photos/comediens/".$bit_saison."/".$id_membre.".jpg";
    $photoBase = "/photos/comediens/".$id_membre.".jpg";

    if (file_exists("$path$photoSaison")) { $photo = $photoSaison; }
    if (file_exists("$path$photoBase")) { $photo = $photoBase; }

    return $photo;
}
