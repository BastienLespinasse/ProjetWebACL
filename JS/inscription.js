var faux_prenom = 0;
var faux_nom = 0;
var faux_login = 0;
var faux_date = 0;
var faux_sexe = 0;
var faux_mail = 0;
var faux_mdp = 0;
var faux_mdp2 = 0;

function contour(champ, erreur)
	{
		if(erreur)
		{
			champ.style.backgroundColor = "#FFCCCC";
		}
		else
		{
			champ.style.borderColor = "#90C3D4";
			champ.style.backgroundColor = "#FAFFBD";
		}
	}

function verif_prenom(prenom)
	{
		var regex = /^[a-zA-Z]{1,100}$/;
		if(!regex.test(prenom.value))
		{
			contour(prenom, true);
			faux_prenom=1;
			return false;
		}
		else
		{
			contour(prenom, false);
			faux_prenom=0;
			return true;
		}
	}

function verif_nom(nom)
	{
		var regex = /^[a-zA-Z]{1,100}$/;
		if(!regex.test(nom.value))
		{
			contour(nom, true);
			faux_nom=1;
			return false;
		}
		else
		{
			contour(nom, false);
			faux_nom=0;
			return true;
		}
	}

function verif_login(login)
	{
		var regex = /^[a-zA-Z0-9]{1,100}$/;
		if(!regex.test(login.value))
		{
			contour(login, true);
			faux_login=1;
			return false;
		}
		else
		{
			contour(login, false);
			faux_login=0;
			return true;
		}
	}

function verif_mail(mail)
	{
		var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
		if(!regex.test(mail.value))
		{
			contour(mail, true);
			faux_mail=1;
			return false;
		}
		else
		{
			contour(mail, false);
			faux_mail=0;
			return true;
		}
	}

function verif_mdp(mdp)
	{
		var regex = /^[a-zA-Z0-9._-]{4,10}$/;
		if(!regex.test(mdp.value))
		{
			contour(mdp, true);
			faux_mdp=1;
			return false;
		}
		else
		{
			contour(mdp, false);
			faux_mdp=0;
			return true;
		}
	}

function verif_mdp2(mdp2)
	{
		var regex = /^[a-zA-Z0-9._-]{4,10}$/;
		if(!regex.test(mdp2.value)||((document.getElementById("mdp2").value)!=(document.getElementById("mdp").value)))
		{
			contour(mdp2, true);
			faux_mdp2=1;
			return false;
		}
		else
		{
			contour(mdp2, false);
			faux_mdp2=0;
			return true;
		}
	}


function valider()
	{
		var prenom = document.getElementById("prenom").value;
		var nom = document.getElementById("nom").value;
		var login = document.getElementById("login").value;
		var mail = document.getElementById("mail").value;
		var mdp = document.getElementById("mdp").value;
		var mdp2 = document.getElementById("mdp2").value;

		if ((prenom == "" | nom == ""| login == ""| mail == "" | mdp == "" | mdp2 == "")||(faux_prenom==1)||(faux_nom==1)||(faux_login==1)||(faux_mail==1)||(faux_mdp==1)||(faux_mdp2==1))
			{
				alert("Vous n'avez pas rempli correctement le formulaire !");

				if(prenom == "")
				{
					alert("Le champ Prenom est vide" );
				}

				if(nom == "")
				{
					alert("Le champ Nom est vide" );
				}

				if(login == "")
				{
					alert("Le champ Login est vide" );
				}

				if(mail == "")
				{
					alert("Le champ Numéro de Adresse e-mail est vide" );
				}

				if(mdp == "")
				{
					alert("Le champ Mot de passe est vide" );
				}

				if(mdp2 == "")
				{
					alert("Le champ Confirmer le Mot de passe est vide" );
				}
			}
	}

