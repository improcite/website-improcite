<div class="row">
  <div class="col-md-4 my-3 text-center">
    <img src="{$infos.photo}" class="img-fluid rounded shadow" alt="{$infos.nom}"/>
  </div>
  <div class="col-md-8 my-3">
    <div class="card">
      <div class="card-header text-center">
        <h4 class="card-title">{$infos.nom}</h4>
      </div>
      <div class="card-body">
        <h5 class="card-text">
          <i class="fa fa-calendar-days"></i> {$infos.unixdate|date_format:"Le %d/%m/%Y à %Hh%M"}
        </h5>
        <p class="card-text">
        {if $infos.ecommentaire}
        {$infos.ecommentaire}
        {else}
        {$infos.description}
        {/if}
        </p>
        {include file="joueurs.tpl" joueurs=[{$infos.joueurs},{$infos.mc},{$infos.arbitre},{$infos.animateurs}]|join:';'}
      </div>
      <div class="card-header">
        <h5 class="card-title"><i class="fa fa-location-dot"></i> {$infos.lnom}</h5>
        {$infos.ladresse}
        {if $infos.ladresse}<br />{$infos.ladresse2}{/if}
      </div>
      {if $infos.lcoordonnees}
      <div id="map" class="card-img-bottom" style="width: 100%; height: 400px;"></div>
      {/if}
    </div>
  </div>
</div>


{if $infos.lcoordonnees}
<script src="/assets/leaflet/leaflet.js"></script>
<script type="text/javascript">
var coordonnees = "{$infos.lcoordonnees}".split("/");
var nom = "{$infos.lnom}";
var adresse = "{$infos.ladresse}";
{literal}
var map = L.map('map').setView([coordonnees[1], coordonnees[2]], coordonnees[0]);
var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([coordonnees[1], coordonnees[2]]).addTo(map);
marker.bindPopup("<b>"+nom+"</b><br />" + adresse).openPopup();
{/literal}
</script>
{/if}
<div class="d-grid">
  <a href="/?p=agenda" class="btn btn-primary my-4" type="button">Voir nos autres dates</a>
</div>
