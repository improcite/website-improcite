<div class="row">
{foreach $joueurs|split:';' as $joueur}
{if $joueur}
{get_membre_min mysqli=$mysqli table_comediens=$table_comediens id=$joueur infos="infos"}
<div class="col-3 text-center mb-2">
<img src="{photo_membre id_membre={$joueur} id_saison={$id_saison}}" class="img-fluid rounded shadow" alt="Photo de {$infos.prenom}" title="{$infos.prenom}" /> <span class="small">{$infos.prenom}</span>
</div>
{/if}
{/foreach}
</div>
