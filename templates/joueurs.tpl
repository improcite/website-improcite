<div class="row">
{foreach $joueurs|split:';' as $joueur}
{if $joueur}
<div class="col-4 text-center mb-2">
<img src="{photo_membre id_membre={$joueur} id_saison={$id_saison}}" class="img-fluid rounded shadow" />
</div>
{/if}
{/foreach}
</div>
