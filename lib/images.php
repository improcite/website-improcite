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
