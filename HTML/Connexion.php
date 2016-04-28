<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_POST['bouton_connect'])) 
{
	$login_connect = htmlspecialchars($_POST['login_connect']);
	$mdp_connect = sha1($_POST['mdp_connect']);

	if (!empty($_POST['login_connect']) AND !empty($_POST['mdp_connect']))
	{
		$requser = $bdd -> prepare("SELECT * FROM membre WHERE login = ? AND motdepasse = ?");
		$requser -> execute(array($login_connect, $mdp_connect));
		$userexist = $requser -> rowCount();

		if ($userexist > 0) 
		{	
			$userinfo = $requser -> fetch();
			$_SESSION['id'] = $userinfo['id'];
			$_SESSION['login'] = $userinfo['login'];
			header("Location: Profil.php?id=".$_SESSION['id']);
		}
		else
		{
			$erreur = "Login ou mot de passe incorrect !";
		}
	}
	else
	{
		$erreur = "Tous les champs doivent être remplis !";
	}
}

?>

<html>
	<head>
		<meta charset="utf-8" />
		<title>connexion</title>
		<link rel="stylesheet" href="..\CSS\connexion.css" /> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">		
	</head>

	<body>
			<table id="page_table"><tr><td id="page_td">
				<form id="form" method="POST" action="Connexion.php">
						<input placeholder="Login" name="login_connect" value="<?php if (isset($login)) {echo $login;} ?>" onBlur="verif_login(login)"></br></br>
						<input type="password" placeholder="Mot de passe" name="mdp_connect" value="" onBlur="verif_age(age)"></br></br>
						<input id="bouton" type="submit" name="bouton_connect" value="valider" onClick= "..\HTML\accueil.html">
						<p id="inscription">Vous n'avez pas de compte ? <a href="Inscription.php">Inscrivez-vous !</a></p>
				</form>	
				<?php
				if (isset($erreur)) 
					{
					echo $erreur;
				}
			?>
			</td></tr></table>	

	</body>

	<!--<script type="text/javascript" src="..\JS\connexion.js">
  	</script>-->
	
</html>
