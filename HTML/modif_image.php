<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

    if (isset ($_GET['id'])) 
    { 
        $reqimages = $bdd ->prepare('SELECT * FROM images WHERE id=?');
        $reqimages -> execute(array($_GET['id']));
        $data = $reqimages -> fetch();
        
        if (isset($_POST['new_nom']) AND !empty($_POST['new_nom']) AND $_POST['new_nom'] != $data['nom']) 
        {
            $new_nom = htmlspecialchars($_POST['new_nom']); /* on sécurise notre variable */
            $insertnom = $bdd -> prepare("UPDATE images SET nom = ? WHERE id = ?");
            $insertnom -> execute(array($new_nom, $_GET['id']));
            header("Location: modif_image.php?id=".$data['id']);
        }

        if (isset($_POST['new_lieu']) AND !empty($_POST['new_lieu']) AND $_POST['new_lieu'] != $data['lieu']) 
        {
            $new_lieu = htmlspecialchars($_POST['new_lieu']); /* on sécurise notre variable */
            $insertlieu = $bdd -> prepare("UPDATE images SET lieu = ? WHERE id = ?");
            $insertlieu -> execute(array($new_lieu, $_GET['id']));
            header("Location: modif_image.php?id=".$data['id']);
        }

        if (isset($_POST['new_theme']) AND !empty($_POST['new_theme']) AND $_POST['new_theme'] != $data['theme']) 
        {
            $new_theme = htmlspecialchars($_POST['new_theme']); /* on sécurise notre variable */
            $inserttheme = $bdd -> prepare("UPDATE images SET theme = ? WHERE id = ?");
            $inserttheme -> execute(array($new_theme, $_GET['id']));
            header("Location: modif_image.php?id=".$data['id']);
        }

        if (isset($_POST['new_personnes']) AND !empty($_POST['new_personnes']) AND $_POST['new_personnes'] != $data['personnes_presentes']) 
        {
            $new_personnes = htmlspecialchars($_POST['new_personnes']); /* on sécurise notre variable */
            $insertpersonnes = $bdd -> prepare("UPDATE images SET personnes_presentes = ? WHERE id = ?");
            $insertpersonnes -> execute(array($new_personnes, $_GET['id']));
            header("Location: modif_image.php?id=".$data['id']);
        }

        if (isset($_POST['new_visibilite'])) 
        {

            foreach($_POST['new_visibilite'] as $valeur)
            {
                $insertvisibilite = $bdd -> prepare("UPDATE images SET visibilite = ? WHERE id = ?");
                $insertvisibilite -> execute(array($valeur, $_GET['id']));
                header("Location: modif_image.php?id=".$data['id']);
            }
        }
    
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <title>Modifier votre photo</title>
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
                        <td>Nom</td>
                        <td><?php echo $data['nom'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="theme" placeholder="<?php echo $data['nom'];?>" name="new_nom" class="0"><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Lieu</td>
                        <td><?php echo $data['lieu'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="theme" placeholder="<?php echo $data['lieu'];?>" name="new_lieu" class="0" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Thème</td>
                        <td><?php echo $data['theme'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="theme" placeholder="<?php echo $data['theme'];?>" name="new_theme" class="0" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Personnes présentes</td>
                        <td><?php echo $data['personnes_presentes'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="theme" placeholder="<?php echo $data['personnes_presentes'];?>" name="new_personnes" class="0" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="parametres_tr">
                        <td>Visibilité</td>
                        <td><?php echo $data['visibilite'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif">Publique<input type="radio" name="new_visibilite[]" value="publique">Privée<input type="radio" name="new_visibilite[]" value="privee" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
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

?>