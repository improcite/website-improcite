    <div class="dashboard-nav">
        <header>
            <a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a>
            <a href="index.php" class="brand-logo"><i class="fas fa-carrot me-2"></i>Improcité</a>
        </header>

        <nav class="dashboard-nav-list">
            <div class="nav-item-divider"></div>
            <a href="index.php" class="dashboard-nav-item">
                <i class="fas fa-home"></i>
                Accueil
            </a>
            <a href="index.php?p=membres" class="dashboard-nav-item">
                <i class="fa fa-users"></i>
                Membres
            </a>
            <a href="index.php?p=dispos" class="dashboard-nav-item">
                <i class="fa fa-calendar-check"></i>
                Disponibilités
            </a>
            <a href="index.php?p=stats" class="dashboard-nav-item">
                <i class="fa fa-chart-pie"></i>
                Statistiques
            </a>

            <div class="nav-item-divider"></div>
            <a href="index.php?p=fichiers" class="dashboard-nav-item">
                <i class="fa fa-file"></i>
                Fichiers
            </a>
            <a href="index.php?p=exercices" class="dashboard-nav-item">
                <i class="fa fa-book"></i>
                Exercices
            </a>
{if $display_recrutement_private}
            <a href="index.php?p=recrutements" class="dashboard-nav-item">
                <i class="fa fa-handshake"></i>
                Recrutements
            </a>
{/if}
{if $membre.isAdmin}
            <div class="nav-item-divider"></div>
            <div class='dashboard-nav-dropdown'>
                <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle">
                    <i class="fas fa-cogs"></i>
                    Administration
                </a>
                <div class='dashboard-nav-dropdown-menu'>
                    <a href="index.php?p=admin_users" class="dashboard-nav-dropdown-item"><i class="fas fa-users me-2"></i>Membres</a>
                    <a href="index.php?p=admin_evenements" class="dashboard-nav-dropdown-item"><i class="fas fa-calendar me-2"></i>Événements</a>
                    <a href="index.php?p=admin_categories" class="dashboard-nav-dropdown-item"><i class="fas fa-tag me-2"></i>Catégories</a>
                </div>
            </div>
{/if}
            <div class="nav-item-divider"></div>
            <a href="index.php?p=compte" class="dashboard-nav-item">
                <i class="fas fa-user-ninja"></i>
                Mon compte
            </a>
            <a href="index.php?p=password" class="dashboard-nav-item">
                <i class="fas fa-key"></i>
                Mot de passe
            </a>
            <a href="../" class="dashboard-nav-item">
                <i class="fa fa-map"></i>
                Retour au site
            </a>
            <a href="../?p=sortie" class="dashboard-nav-item">
                <i class="fa fa-door-open"></i>
                Déconnexion
            </a>

        </nav>

    </div>
