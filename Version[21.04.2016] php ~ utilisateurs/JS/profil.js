function deconnexion()
{
	if (confirm("Vous désirez vraiment quitter?"))
	{
   		
  	}

  	else
  	{
   		deconnexion = false;
  	}
}

function erreur()
{
	alert("erreur");
}

/********* AFFICHAGE DES CHAMPS DE MODIFICATIONS DANS PARAMETRES *********/

$(".img").click(function(){
  $(this).closest("td").next().children().css("visibility", "visible");
});

$(".save").click(function(){
  $(this).css("visibility", "hidden");
  $(this).closest("td").children().css("visibility", "hidden");
});

/********* BARRE DES PHOTOS *********/

$(".barre").mouseover(function(){
  $(this).children("div").css("visibility", "visible");
});

$(".barre").mouseout(function(){
  $(this).children("div").css("visibility", "hidden");
});


/********* COEUR ROUGE/BLANC *********/

var saveSrc_coeur = $(".coeur").attr('src'); 

$(".coeur").click(function() { 

var obj_coeur = $(this);

if (saveSrc_coeur != obj_coeur.attr('src')) 
	{
	 $(this).attr('src','../images/jaime_blanc.png');
	} 
else 
{
	 $(this).attr('src','../images/jaime_rouge.png');
}

});

/********* CADENAS JAUNE/BLANC *********/

var saveSrc_cadenas = $(".cadenas").attr('src'); 

$(".cadenas").click(function() { 

var obj_cadenas = $(this);

if (saveSrc_cadenas != obj_cadenas.attr('src')) 
	{
	 $(this).attr('src','../images/cadenas.png');
	} 
else 
{
	 $(this).attr('src','../images/cadenasJ.png');
}

});

/********* PUNAISE JAUNE/BLANCHE *********/

var saveSrc_punaise = $(".punaise").attr('src'); 

$(".punaise").click(function() { 

var obj_punaise = $(this);

if (saveSrc_punaise != obj_punaise.attr('src')) 
	{
	 $(this).attr('src','../images/punaise.png');
	} 
else 
{
	 $(this).attr('src','../images/punaiseJ.png');
}

});


$(".supprimer_bouton").click(function(){
  $(".supprimer").css("visibility", "visible");
  $(".valider").css("visibility", "visible");
   $(".annuler").css("visibility", "visible");
});

$(".annuler").click(function(){
  $(".supprimer").css("visibility", "hidden");
  $(".valider").css("visibility", "hidden");
   $(".annuler").css("visibility", "hidden");
});


$(".amis_infos_td").click(function(){	/*si on clique sur l'icone info*/
	$(".amis_infos_td").next("td").next("td").css("visibility", "hidden");	/*on efface les éventuelles infos déjà à l'écran */
  	$(this).next("td").next("td").css("visibility", "visible");	/*on affiche les infos correspondants à l'icone cliqué*/
});

$(".fermer_infos").click(function(){	/*si on clique sur l'icone fermer*/
	$(".amis_infos_td").next("td").next("td").css("visibility", "hidden");	/*on efface les éventuelles infos déjà à l'écran */
});


