    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><i class="fas fa-carrot me-2"></i>Improcité</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMembres" aria-controls="navbarMembres" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMembres">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=membres"><i class="fa fa-users me-1"></i>Membres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=dispos"><i class="fa fa-calendar-check me-1"></i>Disponibilités</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=stats"><i class="fa fa-chart-pie me-1"></i>Statistiques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=fichiers"><i class="fa fa-file me-1"></i>Fichiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=exercices"><i class="fa fa-book me-1"></i>Exercices</a>
                </li>
{if $display_recrutement_private}
                <li class="nav-item">
                    <a class="nav-link" href="index.php?p=recrutements"><i class="fa fa-handshake me-1"></i>Recrutements</a>
                </li>
{/if}
{if $membre.isAdmin}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cogs me-1"></i>Administration
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?p=admin_users"><i class="fas fa-users me-2"></i>Membres</a></li>
                        <li><a class="dropdown-item" href="index.php?p=admin_evenements"><i class="fas fa-calendar me-2"></i>Événements</a></li>
                        <li><a class="dropdown-item" href="index.php?p=admin_categories"><i class="fas fa-tag me-2"></i>Catégories</a></li>
                        <li><a class="dropdown-item" href="index.php?p=admin_lieux"><i class="fas fa-map-marker-alt me-2"></i>Lieux</a></li>
                    </ul>
                </li>
{/if}
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" alt="{$membre.prenom}" width="32" height="32" class="rounded-circle me-2" />
                        {$membre.prenom} {$membre.nom}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?p=compte"><i class="fas fa-user-ninja me-2"></i>Mon compte</a></li>
                        <li><a class="dropdown-item" href="index.php?p=password"><i class="fas fa-key me-2"></i>Mot de passe</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../"><i class="fa fa-map me-2"></i>Voir le site</a></li>
                        <li><a class="dropdown-item" href="../?p=sortie"><i class="fa fa-door-open me-2"></i>Se déconnecter</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
