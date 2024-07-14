{include file="header.tpl"}

{include file="menu.tpl"}

        <div class="bg-light flex-fill">
            <div class="p-3 d-md-none d-flex text-white bg-dark">
                <a href="#" class="text-white"
                   data-bs-toggle="offcanvas"
                   data-bs-target="#sidebar">
                    <i class="fa-solid fa-carrot"></i>
                </a>
                <span class="ms-3">Improcité - Saison {get_saison_string id_saison={$id_saison}}</span>
            </div>
            <div class="p-4">
                <div class="row">
                    <div class="col">
                    {include file="{$p}.tpl"}
                    </div>
                </div>
            </div>

        </div>


{include file="footer.tpl"}
