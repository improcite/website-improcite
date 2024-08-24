        <div id="sidebar"
             class="d-flex flex-column
                    flex-shrink-0
                    px-5 py-3 bg-dark
                    text-white offcanvas-md offcanvas-start">
            <a href="index.php"><img class="img-fluid my-3 mx-auto d-block" src="/assets/images/logo-lapin-improcite-200px.png" alt="Logo Improcite" /></a>
            <p class="text-center">Saison {get_saison_string id_saison={$id_saison}}</p>
            <hr/>
            <ul class="mynav nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="index.php">
                        <i class="fa fa-home"></i>
                        Accueil
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="index.php?p=membres">
                        <i class="fa fa-users"></i>
                        Membres
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="index.php?p=dispos">
                        <i class="fa fa-calendar-check"></i>
                        Disponibilités
                    </a>
                </li>
                <hr />
                <li class="nav-item mb-1">
                    <a href="index.php?p=fichiers">
                        <i class="fa fa-file"></i>
                        Fichiers
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="index.php?p=exercices">
                        <i class="fa fa-book"></i>
                        Exercices
                    </a>
                </li>
                <hr />
                <li class="nav-item mb-1">
                    <a href="index.php?p=recrutements">
                        <i class="fa fa-handshake"></i>
                        Recrutements
                    </a>
                </li>
                {if $membre.isAdmin}
                <li class="nav-item mb-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownAdmin" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-sm-inline mx-1"><i class="fa fa-gears me-2"></i>Administration</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownAdmin">
                        <li><a class="dropdown-item disabled" href="#"><i class="fa fa-users me-2"></i>Membres</a></li>
                        <li><a class="dropdown-item" href="index.php?p=admin_evenements"><i class="fa fa-calendar me-2"></i>Événements</a></li>
                        <li><a class="dropdown-item" href="index.php?p=admin_categories"><i class="fa fa-tag me-2"></i>Catégories</a></li>
                        <li><a class="dropdown-item disabled" href="#"><i class="fa fa-location-dot me-2"></i>Lieux</a></li>
                        <li><a class="dropdown-item disabled" href="#"><i class="fa fa-handshake me-2"></i>Recrutements</a></li>
                    </ul>
                </li>
                {/if}
            </ul>
            <hr>
            <div class="d-flex">
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" alt="{$membre.prenom}" width="28" height="28" class="rounded-circle">
                        <span class="d-sm-inline mx-1">{$membre.prenom}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="index.php?p=compte"><i class="fa fa-user-ninja me-2"></i>Mon compte</a></li>
                        <li><a class="dropdown-item" href="index.php?p=password"><i class="fa fa-key me-2"></i>Changer mon mot de passe</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="../"><i class="fa fa-map me-2"></i>Retour au site public</a></li>
                        <li><a class="dropdown-item" href="../?p=sortie"><i class="fa fa-door-open me-2"></i>Se déconnecter</a></li>
                    </ul>
                </div>

            </div>
        </div>
