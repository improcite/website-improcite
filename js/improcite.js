// JQUERY effects

$(document).ready(function() {
	/* Neige */
	//$().jSnow();
	/* Animation du fond de page */
	// $("body").css({backgroundPosition: '0px 0px'});
	// $("body").animate({backgroundPosition: '2000px 0px'}, 100000);
	/* Cadre de bienvenue */
	$("div#welcome").fadeIn("slow");
	/* Affichage des dates anciennes dans les dispos */
	$("p.toggleOutdated").click(function(){
		$("tr.outdated").toggleClass("hidden");
		});
	/* Omerta */
	// Affichage des personnages
	$("p.date_omerta").click(function(){
		var id = $(this).attr("title");
		var contenu = $("div.contenu_omerta[title="+id+"]").html();
		$("div#personnages_omerta").hide();
		$("div#personnages_omerta").html(contenu);
		$("div#personnages_omerta").fadeIn();;
	});
	/* Menu LavaLamp */
	if($(".lavaLamp") && (".lavaLamp").lavaLamp)
	{
		$(".lavaLamp").lavaLamp({ fx: "backout", speed: 700 });
	}
	/* Message accueil Omerta */
	/*$("h1.omerta").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow");
	$("h1.omerta").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow");
	$("h1.omerta").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow").fadeOut("slow").fadeIn("slow");*/
	/* Validation du formulaire de recrutement */
	//$("form#recrutement").validate({errorElement: "em"});
        $("[data-toggle='tooltip']").tooltip();
});

