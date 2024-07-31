<ul>
{foreach $membres|split:';' as $membre}
{if $membre}
{get_membre_min mysqli=$mysqli table_comediens=$table_comediens id=$membre infos="infos"}
  <li>{$infos.prenom} {$infos.nom}</li>
{/if}
{/foreach}
</ul>
