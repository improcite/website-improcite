<div class="card border-3 rounded shadow">
  <div class="card-body">
  <h1 class="card-title">
Bienvenue sur le site d’Improcité<br />
Troupe d’improvisation à Lyon depuis 2003
  </h1>
  <p class="card-text">
Si toi aussi tu aimes les idées saugrenues sur scène, les plot twists dans un scénario, les répliques au poil entre deux comédiens et l’équilibre subtil entre cohérence et spontanéité, alors tu es au bon endroit.<br />
Notre troupe d’impro à Lyon saura te faire rêver autant que te surprendre. Après tout, la créativité et l’imagination n’ont pas de limites quand il s’agit d’improviser&nbsp;!
  <p>
  </div>
  <img src="/assets/images/photo-header.png" class="card-img" />
</div>

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Nous, c’est Improcité : une troupe d’impro à Lyon qui a la carotte sans oublier ses racines</h2>
  <p class="card-text">
Chez Improcité, on improvise depuis plus de 20 ans.<br />
En effet, notre troupe d’improvisation théâtrale a été créée en 2003 à Villeurbanne. Nous comptons environ <strong><a href="/?p=equipe">15 membres</a></strong> et fonctionnons en tant qu’association. Nos improvisateurs et improvisatrices viennent de tous les horizons et ont tous les âges.<br />
Et ça se ressent dans notre manière de jouer&nbsp;: <strong>on aime improviser sur tout, partout, pour tout le monde</strong>.<br />
Côté localisation, nous faisons de l’impro à Lyon et ses alentours, mais pas seulement ! Nous sommes déjà intervenus partout en France, et même à l’étranger (Belgique, Maroc…). Nous aimons également accueillir d’autres troupes pour faire des <strong>matchs</strong>&nbsp;: plus on est de fous, plus on s’amuse&nbsp;!
  </p>
  </div>
</div>

<div class="card my-3 border-3 border-info">
  <div class="card-header">🐰 Pourquoi un lapin comme mascotte de la troupe ?</div>
  <div class="card-body">
  <p class="card-text">
Rassure-toi, si toi aussi ça t’intrigue, sache que tu n’es pas le premier (et tu ne seras pas le dernier). L’anecdote nous est aussi précieuse qu’elle est absurde. En effet, lors du lancement de notre site internet, un des membres de notre troupe d’impro à Lyon, dont le métier était développeur, travaillait sur le jeu vidéo Lapins Crétins. Il a donc mis une tête de lapin en photo par défaut sur les profils de nos joueurs. Evidemment, on a rapidement adopté ce symbole… jusqu’à en faire notre logo !
  </p>
  </div>
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

