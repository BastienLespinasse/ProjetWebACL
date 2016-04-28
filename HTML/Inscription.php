<?php

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', ''); //On se connecte à la base de données

if (isset($_POST['bouton'])) 
{
	/*** déclaration des variables ***/

	$login = htmlspecialchars($_POST['login']);
	$mail = htmlspecialchars($_POST['mail']);
	$mdp = sha1($_POST['mdp']);		
	$mdp2 = sha1($_POST['mdp2']);
	$loginlength = strlen($login);
	$prenom = htmlspecialchars(($_POST['prenom']));
	$nom = htmlspecialchars(($_POST['nom']));
	$date = ($_POST['date']);

	if (!empty($_POST['login']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])  AND !empty($_POST['prenom'])  AND !empty($_POST['nom'])) 	/*si aucun des champs n'est vide */
		{
			if ($loginlength <= 255) /* si le login fait moins de 255 caractères */
			{
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
				{
					$reqmail = $bdd -> prepare("SELECT * FROM membre WHERE mail = ?");	/*on sélectionne l'attribut mail dans la table membre de la BD */
					$reqmail -> execute(array($mail));	/*on execute la requête */
					$mailexist = $reqmail -> rowCount(); /* on compte le nombre de caractère du mail cherché */

					$reqlogin = $bdd -> prepare("SELECT * FROM membre WHERE login = ?");	/*on sélectionne l'attribut login dans la table membre de la BD */
					$reqlogin -> execute(array($login));	/*on execute la requête */
					$loginexist = $reqlogin -> rowCount();	/* on compte le nombre de caractère du mail cherché */
					if ($mailexist == 0)	/* si aucun mail identique n'est présent dans la table */
					{
						if ($loginexist == 0)	/* si aucun login identique n'est présent dans la table */ 
						{
						
							if ($mdp == $mdp2) /* si les deux mots de passe entrés sont bien identiques */
							{
								$insertmembre = $bdd -> prepare("INSERT INTO  membre(login, mail, motdepasse, prenom, nom, date_naissance, avatar, admin, photos, albums) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); /*ajout d'un nouveau memnre*/
								$insertmembre -> execute(array($login, $mail, $mdp, $prenom, $nom, $date, "profil.jpg", 0, 0, 0)); /* on execute la requête */
								$erreur = "Votre compte a bien été créé !"; /* on affiche la confirmation de la création du compte */
								header("Location: Connexion.php");
							}
							else
							{
								$erreur = "Veuillez entrer deux mots de passe identiques !"; /* si les deux mots de passe diffèrent, on affiche l'erreur */
							}
						}
						else
						{
							$erreur = "Votre login est déjà utilisé !"; /* si le login existe déjà dans la table, on affiche l'erreur */
						}
					}
					else
					{
						$erreur = "Votre addresse mail est déjà utilisée !";	/* si l'adresse mail existe déjà dans la table, on affiche l'erreur */
					}
				}
				else
				{
					$erreur = "Votre addresse mail n'est pas valide !";
				}
			}
			else
			{
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";	/* si le login dépasse 255 caractère, on affiche l'erreur*/
			}
		}	
	else
	{
		$erreur = "Tous les champs doivent être remplis !";	/* si des champs ne sont pas remplis, on affiche l'erreur */
	}
}

?>


<html>
	<head>
		<meta charset="utf-8" />
		<title>inscription</title>
		<link rel="stylesheet" href="..\CSS\inscription.css" /> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	</head>

	<body>
			<table id="page_table"><tr><td id="page_td">
				<form id="form" method="POST" action="">
						<input id="prenom" placeholder="Prénom" name="prenom" value="" onBlur="verif_prenom(prenom)"></br></br>
						<input id="nom" placeholder="Nom" name="nom" value="" onBlur="verif_nom(nom)"></br></br>
						<input id="login" placeholder="Login" name="login" value="" onBlur="verif_login(login)"></br></br>
						<input id="date" type="date" name="date" value="" onBlur=""></br></br>
						<div id="sexe">	
							<ul>
								<li><label for="homme">Homme</label><input type="radio" id="homme" name="sexe"/></li>
								<li><label for="femme">Femme</label><input type="radio" id="femme" name="sexe"/></li>
							</ul>
						</div>
						<input id="mail" placeholder="Adresse e-mail" name="mail" value="" onBlur="verif_mail(mail)"></br></br>
						<input type="password" id="mdp" placeholder="Mot de passe" name="mdp" value="" onBlur="verif_mdp(mdp)"></br></br>
						<input type="password" id="mdp2" placeholder="Confirmer le mot de passe" name="mdp2" value="" onBlur="verif_mdp2(mdp2)"></br></br>
						<input id="bouton" type="submit" name="bouton" value="valider" onClick="valider()">
				</form>	
				<?php
				if (isset($erreur)) 
					{
					echo $erreur;
				}
			?>
			</td></tr></table>	

	</body>

	<script type="text/javascript" src="..\JS\inscription.js">
  	</script>
	
</html>
