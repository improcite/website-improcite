document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('btnGeocode');
    if (!btn) return;
    btn.addEventListener('click', function() {
        var adresse = document.getElementById('inputAdresse').value.trim();
        if (!adresse) {
            document.getElementById('geocodeResult').innerHTML = '<span class="text-danger">Veuillez saisir une adresse.</span>';
            return;
        }
        var resultDiv = document.getElementById('geocodeResult');
        resultDiv.innerHTML = '<span class="text-secondary"><i class="fa fa-spinner fa-spin me-1"></i>Recherche en cours\u2026</span>';
        var url = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(adresse);
        fetch(url, { headers: { 'Accept-Language': 'fr' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                if (data && data.length > 0) {
                    var lat = parseFloat(data[0].lat).toFixed(6);
                    var lon = parseFloat(data[0].lon).toFixed(6);
                    document.getElementById('inputCoordonnees').value = '18/' + lat + '/' + lon;
                    resultDiv.innerHTML = '<span class="text-success"><i class="fa fa-check me-1"></i>Coordonn\u00e9es trouv\u00e9es\u00a0: ' + lat + ', ' + lon + '</span>';
                } else {
                    resultDiv.innerHTML = '<span class="text-warning"><i class="fa fa-triangle-exclamation me-1"></i>Adresse introuvable. Veuillez saisir les coordonn\u00e9es manuellement.</span>';
                }
            })
            .catch(function() {
                resultDiv.innerHTML = '<span class="text-danger"><i class="fa fa-circle-exclamation me-1"></i>Erreur lors de la requ\u00eate. Veuillez r\u00e9essayer.</span>';
            });
    });
});
