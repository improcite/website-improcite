<h1 class="text-center my-3"><i class="fa fa-user"></i> {$infos.prenom} {if $infos.surnom}({$infos.surnom}){/if}</h1>

<div class="row">
  <div class="col-md-4 mb-2 text-center">
    <img src="{photo_membre id_membre={$infos.id} id_saison={$id_saison}}" class="img-fluid rounded shadow" alt="Photo de {$infos.prenom}" title="{$infos.prenom}" />
  </div>
  <div class="col-md-8 mb-2">
    <div class="accordion" id="accordeonMembre">
    {assign var=items value=['debut' => "Début dans l'improvisation", 'envie' => "Comment as-tu eu envie de faire de l'improvisation&nbsp;?", 'apport' => "Que t'apporte l'improvisation ?", 'debutimprocite' => "Ton arrivée à Improcité ?", 'improcite' => "Pour toi Improcité c'est quoi ?",'qualite' => "Qualité en impro", 'defaut' => "Défaut en impro"]}
    {foreach $items as $item => $label}
    {if $infos.$item}
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button {if $label@index ne 0}collapsed{/if}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{$item}" aria-expanded="{if $label@index eq 0}true{else}false{/if}" aria-controls="collapse{$item}">
        {$label}
        </button>
      </h2>
      <div id="collapse{$item}" class="accordion-collapse collapse {if $label@index eq 0}show{/if}" data-bs-parent="#accordeonMembre">
        <div class="accordion-body bg-body-secondary">
        {$infos.$item}
        </div>
      </div>
    </div>
     {/if}
     {/foreach}
    </div>
  </div>
</div>

<div class="d-grid">
  <a href="/?p=equipe" class="btn btn-primary my-4" type="button">Découvrir les autres membres de l'équipe</a>
</div>
