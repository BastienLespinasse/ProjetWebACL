function couleur_bouton1()
{
	document.getElementById("bouton1").className = "fond2";
}

function retour_couleur1()
{
	document.getElementById("bouton1").className = "fond1";
}

function couleur_bouton2()
{
	document.getElementById("bouton2").className = "fond2";
}

function retour_couleur2()
{
	document.getElementById("bouton2").className = "fond1";
}

function couleur_bouton4()
{
	document.getElementById("bouton4").className = "fond2";
}

function retour_couleur4()
{
	document.getElementById("bouton4").className = "fond1";
}

function scroll()
{
	window.scrollTo(0, 650);
}

function negatif()
{
	document.getElementById("fleche").src = "../images/fleche_inv.png";
}

function retour_normal()
{
	document.getElementById("fleche").src = "../images/fleche.png";
}