<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_SESSION['id'])) /* si une personne est connectée */
{
    $requser = $bdd -> prepare("SELECT * FROM membre WHERE id =?");
    $requser -> execute(array($_SESSION['id']));
    $user = $requser -> fetch();

    if (isset($_POST['new_login']) AND !empty($_POST['new_login']) AND $_POST['new_login'] != $user['login']) 
    {
        $new_login = htmlspecialchars($_POST['new_login']); /* on sécurise notre variable */
        $insertlogin = $bdd -> prepare("UPDATE membre SET login = ? WHERE id = ?");
        $insertlogin -> execute(array($new_login, $_SESSION['id']));
        header("Location: Parametres.php");
    }

     if(isset($_POST['new_mail']) AND !empty($_POST['new_mail']) AND $_POST['new_mail'] != $user['mail']) 
    {
        $new_mail = htmlspecialchars($_POST['new_mail']); /* on sécurise notre variable */
        $insertmail = $bdd -> prepare("UPDATE membre SET mail = ? WHERE id = ?");
        $insertmail -> execute(array($new_mail, $_SESSION['id']));
        header("Location: Parametres.php");
    }

    if(isset($_POST['new_mdp1']) AND !empty($_POST['new_mdp1'])) 
    {
        $new_mdp1 = sha1($_POST['new_mdp1']);

            $insertmdp = $bdd -> prepare("UPDATE membre SET motdepasse = ? WHERE id = ?");
            $insertmdp -> execute(array($new_mdp1, $_SESSION['id']));
            header("Location: Parametres.php");       
    }

    if (isset($_POST['new_login']) AND $_POST['new_login'] == $user['login']) 
    {
        header("Location: Parametres.php");
    }

    if (isset($_POST['new_prenom']) AND !empty($_POST['new_prenom']) AND $_POST['new_prenom'] != $user['prenom']) 
    {
        $new_prenom = htmlspecialchars($_POST['new_prenom']); /* on sécurise notre variable */
        $insertprenom = $bdd -> prepare("UPDATE membre SET prenom = ? WHERE id = ?");
        $insertprenom -> execute(array($new_prenom, $_SESSION['id']));
        header("Location: Parametres.php");
    }

    if (isset($_POST['new_nom']) AND !empty($_POST['new_nom']) AND $_POST['new_nom'] != $user['nom']) 
    {
        $new_nom = htmlspecialchars($_POST['new_nom']); /* on sécurise notre variable */
        $insertnom = $bdd -> prepare("UPDATE membre SET nom = ? WHERE id = ?");
        $insertnom -> execute(array($new_nom, $_SESSION['id']));
        header("Location: Parametres.php");
    }

    if (isset($_POST['new_date']) AND !empty($_POST['new_date']) AND $_POST['new_date'] != $user['date']) 
    {
        $new_date = ($_POST['new_date']); /* on sécurise notre variable */
        $insertdate = $bdd -> prepare("UPDATE membre SET date_naissance = ? WHERE id = ?");
        $insertdate -> execute(array($new_date, $_SESSION['id']));
        header("Location: Parametres.php");
    }

    if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) 
    {
        $taille_max = 2097152; /*taille max de l'image uploadée */
        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png'); /*formats supportés */

        if ($_FILES['avatar']['size'] <= $taille_max) /* si l'image n'est pas trop grande */
        {
            $extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], "."), 1)); /*strrchr : renvoit l'extension du fichier ; substr : ignore le premier (1) caractère de la chaine ; strtolower : tout en minuscule */ 
            if (in_array($extension_upload, $extensions_valides)) 
            {
                $chemin = "avatars/".$_SESSION['id'].".".$extension_upload;
                $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);

                if ($resultat) 
                {
                    $update_avatar = $bdd -> prepare('UPDATE membre SET avatar = :avatar WHERE id = :id');
                    $update_avatar -> execute(array(
                        'avatar' => $_SESSION['id'].".".$extension_upload,
                        'id' => $_SESSION['id']
                        ));
                    header("Location: Parametres.php");
                }
                else
                {
                    $msg = "Erreur lors de l'importation de votre photo.";
                }
            }
            else
            {
                $msg = "Formats supportés : jpg, jpeg, gif et png";
            }
        }
        else
        {
            $msg = "Votre photo de profil ne doit pas dépasser 2Mo !";
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <title>Paramètres </title>
    </head>

    <body>
    	
    	<div id="header">
            <table id="header_table"><tr><td id="header_td">
                <ul id="menu">
                    <li id="accueil"><a href="Accueil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/home.png" id="home_ico" />Accueil</a></li>
                    <li id="profil"><a href="Profil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/people.png" id="people_ico" />Mon profil</a></li>
                    <li id="parametres"><a href="Parametres.php"><img src="../images/parametres.png" id="parametres_ico" />Paramètres</a></li>
                    <li id="deconnexion"><a href="Deconnexion.php" onClick="deconnexion()"><img src="../images/deconnexion.png" id="deconnexion_ico" onClick="deconnexion()" /> Se déconnecter</a></li>
                </ul>
            </td></tr></table>
        </div>


        <div id="contenu">    
            <table id="contenu_table"><tr><td id="contenu_td">   
            <form method="POST" action="" enctype="multipart/form-data">            
                <table id="parametres_table">
                    <tr id="parametres_tr">
                        <td>Prénom</td>
                        <td><?php echo $user['prenom'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="prenom" placeholder="Prénom" name="new_prenom" class="0" onBlur="verif_prenom(prenom)" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Nom</td>
                        <td><?php echo $user['nom'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_nom" class="modif"><input id="nom" placeholder="Nom" name="new_nom" class="0" onBlur="verif_prenom(prenom)" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Login</td>
                        <td><?php echo $user['login'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_login" class="modif"><input id="login" placeholder="Login" name="new_login" onBlur="verif_login(login)"><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Date de naissance</td>
                        <td><?php echo $user['date_naissance'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_date" class="modif"><input id="date" type="date" name="new_date" value="" onBlur=""><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Adresse e-mail</td>
                        <td><?php echo $user['mail'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_mail" class="modif"><input type="email" id="mail" placeholder="Adresse e-mail" name="new_mail" onBlur="verif_mail(mail)"><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Mot de passe</td>
                        <td></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_mdp" class="modif"><input type="password" id="mdp" placeholder="Mot de passe" name="new_mdp1" value="" onBlur="verif_mdp(mdp)"><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td><a href="#photo_profil_amis_grand"><img src="avatars/<?php echo $user['avatar']; ?>"  class="photo_profil" id="photo_profil_amis" /></a></td>
                        <td>Modifier votre photo de profil</td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_mdp" class="modif"><input type="file" name="avatar" id="modifier_avatar" value=""><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>  
                    </table>
                    </br></br></br><input type="submit" value="Valider" id="bouton" />      
                </form>
                <?php
                    if (isset($msg)) 
                    {
                        echo $msg;
                    }
                ?>
            </td></tr></table>  
        </div>

        <footer>
            </br><p id="lignef1">Nom_site</p>
            <div id="lignef2">
                <ul>
                    <li><a href="a_propos.html">A propos</a></li>
                    <li><a href="contacts.html">Contacts</a></li>
                </ul>
            </div>
        </footer>

    </body>

    <script type="text/javascript" src="../JS\profil.js">
        </script>

</head>

<?php
}

else
{
    header("Location: Connexion.php");                      
}

?>