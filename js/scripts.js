// Fonction de changement d'image

function swapImage(id,img) {
	
	document[id].src=img ;

}

// Bandeau defilant

function defil(texte,size) {

	texteDef = texte ;
	x = 3*size ;
	texteDef = texteDef.substring(1,texteDef.length) ;
	while(texteDef.length < x) {
		texteDef += " - " + texte;
	}
	document.defil.defilbox.value = texteDef ;
	//tempo = setTimeout("defil()", 150) ;
}
