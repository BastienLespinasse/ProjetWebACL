function jaime_rouge()
{
	if (document.getElementById("jaime_ico").value == 0 ) 
	{
		document.getElementById("jaime_ico").src = "../images/jaime_rouge.png";
		document.getElementById("jaime_ico").value = 1;
	}
	else
	{
		document.getElementById("jaime_ico").src = "../images/jaime_blanc.png";
		document.getElementById("jaime_ico").value = 0;
	}
}

function cadenas_jaune()
{
	if (document.getElementById("cadenas_ico").value == 0 ) 
	{
		document.getElementById("cadenas_ico").src = "../images/cadenasJ.png";
		document.getElementById("cadenas_ico").value = 1;
	}

	else 
	 {
	 	document.getElementById("cadenas_ico").src = "../images/cadenas.png";
	 	document.getElementById("cadenas_ico").value = 0;
	 }
	
}

function barre()
{
	document.getElementById("barre").style.visibility = "visible";
}

function non_barre(barre)
{
	document.getElementById("barre").style.visibility = "hidden";
}

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