// JQUERY effects

$(document).ready(function() {
//	$().jSnow();
//	$("body").css({backgroundPosition: '0px 0px'});
//	$("body").animate({backgroundPosition: '2000px 0px'}, 100000);
	$("div#welcome").fadeIn("slow");
	// Affichage des dates anciennes dans les dispos
	$("p.toggleOutdated").click(function(){
		$("tr.outdated").toggleClass("hidden");
	});
});
