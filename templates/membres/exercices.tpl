<div class="clearfix">
  <h3 class="float-start"><i class="fa fa-book"></i> Exercices</h3>
  {if $action == "creation"}
  <a class="btn btn-secondary float-end" role="button" href="index.php?p=exercices"><i class="fa fa-list me-2"></i>Retour à la liste</a>
  {else}
  <a class="btn btn-success float-end" role="button" href="index.php?p=exercices&action=creation"><i class="fa fa-circle-plus me-2"></i>Nouveau</a>
  {/if}
</div>
<hr />

        <div class="ratio ratio-4x3">
{if $action == "creation"}
          <iframe src="{$airtables_form_url}"></iframe>
{else}
          <iframe src="{$airtables_cards_url}"></iframe>
{/if}
        </div>
