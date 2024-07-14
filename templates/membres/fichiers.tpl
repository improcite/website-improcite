<h3><i class="fa fa-file"></i> Fichiers</h3>
<hr />

<div class="boxExplorer h-100"></div>

{literal}
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Intl"></script>
<script src="https://cdn01.boxcdn.net/platform/elements/11.0.2/fr-FR/explorer.js"></script>

<script>
var xmlhttp = new XMLHttpRequest();
xmlhttp.open("GET", "getBoxToken.php");
xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xmlhttp.send();

xmlhttp.onload = function() {
    var contentExplorer = new Box.ContentExplorer();
    contentExplorer.show('0', this.response, {container: '.boxExplorer', logoUrl: '../assets/images/favicon-improcite-fond.png', size: 'large'});
};
</script>
{/literal}

