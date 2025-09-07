{include file="header.tpl"}

{include file="menu.tpl"}

    <div class='dashboard-app'>
        <header class='dashboard-toolbar d-flex'>
           <div class="p-2"><a href="#!" class="menu-toggle"><i class="fas fa-bars"></i></a></div>
           <div class="p-2 flex-grow-1"><span class="fs-4">Espace membres - Saison {get_saison_string id_saison={$id_saison}}</span></div>
           <div class="p-2"><img src="{photo_membre id_membre={$membre.id} id_saison={$id_saison} path=".."}" alt="{$membre.prenom}" width="50" height="50" class="rounded-circle me-3" />{$membre.prenom} {$membre.nom}</div>
        </header>
        <div class='dashboard-content'>
            <div class='container-fluid'>
                    {include file="{$p}.tpl"}
            </div>
        </div>
    </div>

{include file="footer.tpl"}
