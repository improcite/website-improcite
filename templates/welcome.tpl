<div class="card border-3 rounded shadow">
  <div class="card-body">
  <h1 class="card-title text-center">
Bienvenue sur le site d’Improcité<br />
Troupe d’improvisation à Lyon depuis 2003
  </h1>
  <p class="card-text">
Si toi aussi tu aimes les idées saugrenues sur scène, les plot twists dans un scénario, les répliques au poil entre deux comédiens et l’équilibre subtil entre cohérence et spontanéité, alors tu es au bon endroit.</p>
  <p class="card-text">
Notre troupe d’impro à Lyon saura te faire rêver autant que te surprendre. Après tout, la créativité et l’imagination n’ont pas de limites quand il s’agit d’improviser&nbsp;!
  </p>
  </div>
  <img src="/assets/images/photo-header.png" class="card-img" />
</div>

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Nous, c’est Improcité : une troupe d’impro à Lyon qui a la carotte sans oublier ses racines</h2>
  <p class="card-text">
Chez Improcité, on improvise depuis plus de 20 ans.</p>
  <p class="card-text">
En effet, notre troupe d’improvisation théâtrale a été créée en 2003 à Villeurbanne. Nous comptons environ <strong><a href="/?p=equipe">15 membres</a></strong> et fonctionnons en tant qu’association. Nos improvisateurs et improvisatrices viennent de tous les horizons et ont tous les âges.<br />
Et ça se ressent dans notre manière de jouer&nbsp;: <strong>on aime improviser sur tout, partout, pour tout le monde</strong>.</p>
  <p class="card-text">
Côté localisation, nous faisons de l’impro à Lyon et ses alentours, mais pas seulement ! Nous sommes déjà intervenus partout en France, et même à l’étranger (Belgique, Maroc…). Nous aimons également accueillir d’autres troupes pour faire des <strong>matchs</strong>&nbsp;: plus on est de fous, plus on s’amuse&nbsp;!
  </p>
  </div>
</div>

<div class="card my-3 border-3 border-info">
  <div class="card-header fs-2">🐰 Pourquoi un lapin comme mascotte de la troupe ?</div>
  <div class="card-body">
  <p class="card-text">
Rassure-toi, si toi aussi ça t’intrigue, sache que tu n’es pas le premier (et tu ne seras pas le dernier). Alors voici l'explication...</p>
  <p class="card-text">
Lors des premières années de la troupe, l'un des développeurs du site internet travaillait sur le jeu vidéo Rayman et les Lapins Crétins. En cherchant une image à mettre par défaut comme photo de profil, il a pris une image d'un des personnsages et ajouté une cible (car nos spectacles s'appelaient à l'époque les Z'improssibles)</p>
  <p class="card-text">
Dès lors, les autres troupes ont associé Improcité à ce lapin, que nous avons utilisé dans nos différentes versions de logos&nbsp;!
</p>
<div class="mx-auto text-center row">
<div class="col-sm">
  <img src="/assets/images/photo_membre_defaut.jpg" alt="Image de profil d'orgine avec un lapin devant une cible" class="img-fluid img-thumbnail my-2 me-2" style="max-height: 200px;" />
</div>
<div class="col-sm">
  <img src="/assets/images/mascotte-transparent.png" alt="Mascotte lapin avec un noeud papillon" class="img-fluid img-thumbnail my-2 me-2" style="max-height: 200px;" />
</div>
<div class="col-sm">
  <img src="/assets/images/logo-lapin-improcite-avecfond.png" alt="Logo actuel avec un lapin caché derrière une carotte" class="img-fluid img-thumbnail my-2" style="max-height: 200px;" />
</div>
</div>
  </div>
</div>

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Nos spectacles d’improvisation théâtrale dans la région lyonnaise et ailleurs</h2>
  <p class="card-text">
En tant que troupe d’impro à Lyon bien installée depuis des années, nous avons le plaisir de jouer régulièrement dans divers lieux de la scène lyonnaise.</p>
  <p class="card-text">
Nos spectacles d’improvisation théâtrale prennent différentes formes&nbsp;:</p>
  <p class="card-text">
🎭 Format court (short form) type cabaret<br />
🪶 Format long (long form)<br />
⚽ Match d’impro<br />
🥊 Catch d’impro
  </p>
{if count($dates)}
  <p class="card-text">
Tu as envie de voir nos improvisateurs et nos improvisatrices à l’œuvre ? Voici un aperçu de nos prochaines dates.
  </p>
{/if}
  </div>
</div>

{if count($dates)}
<div class="row">
{for $date_id = 0 to count($dates)-1}
{include file="date.tpl" date=$dates.$date_id}
{/for}
</div>
{/if}

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Découvre nos improvisateurs et nos improvisatrices</h2>
  <p class="card-text">
Improcité, c’est avant tout une bande de joyeux drilles qui aiment l’impro (étonnant), mais surtout avec des personnalités toutes distinctes. Notre troupe compte une quinzaine de membres environ. Cela nous permet notamment de prendre le temps de tisser de précieux liens, et ça fait la différence en matière d’alchimie sur scène&nbsp;!</p>
  <p class="card-text">
Alors, qui sont celles et ceux qui sauront te faire t’évader le temps d’un spectacle d’improvisation théâtrale à Lyon&nbsp;?
  </p>
  </div>
  <div class="card-footer text-center">
  <a href="/?p=equipe" class="btn btn-primary" type="button">Viens voir nos bouilles incroyables</a>
  </div>
</div>

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Faire de l’improvisation à Lyon avec Improcité&nbsp;: comment se passe le recrutement&nbsp;?</h2>
  <p class="card-text">
Nous organisons <strong>un recrutement par an</strong>, aux alentours du mois de septembre. Elle se divise en <strong>deux séances</strong>  d’impro à Lyon (des soirées de 2h environ). Objectif&nbsp;: connaître les candidats pendant des exercices d’improvisation de toute sorte (et autour d’un bon buffet).</p>
  <p class="card-text">
Les Improcitadins en charge du recrutement font ensuite une présélection à l’issue de la première session, et une sélection finale à la fin de la seconde.
  </p>
  </div>
</div>

<div class="card my-3 border-3">
  <div class="card-body">
  <h2 class="card-title">Parlons impro&nbsp;: écris-nous&nbsp;!</h2>
  <p class="card-text">
Tu as des questions&nbsp;? Tu veux connaître nos dernières actualités&nbsp;? Tu as envie de taper la discute&nbsp;? Tu aimerais débattre de la préservation des moules au Mozambique&nbsp;?</p>
  <p class="card-text">
🌐 Retrouve-nous sur les réseaux sociaux et envoie-nous un message&nbsp;!
  </p>
  </div>
  <div class="card-footer text-center">
  <a href="https://www.facebook.com/improcite" class="btn btn-primary" type="button" target="_blank"><i class="fa-brands fa-square-facebook me-2"></i>Facebook</a>
  <a href="https://www.instagram.com/improcite/" class="btn btn-primary" type="button" target="_blank"><i class="fa-brands fa-square-instagram me-2"></i>Instagram</a>
  </div>
</div>
