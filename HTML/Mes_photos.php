<!DOCTYPE>

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_SESSION['id'])) 
{
    $requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
    $requser -> execute(array($_SESSION['id']));
    $userinfo = $requser -> fetch();

     if (isset($_POST['bouton'])) 
        {
            if ( isset($_FILES['fic']) )
            {

                $taille_max = 3145728; /*taille max de l'image uploadée */
                $extensions_valides = array('jpg', 'jpeg', 'gif', 'png'); /*formats supportés */

                if ($_FILES['fic']['size'] <= $taille_max) /* si l'image n'est pas trop grande */
                {
                    $extension_upload = strtolower(substr(strrchr($_FILES['fic']['name'], "."), 1)); /*strrchr : renvoit l'extension du fichier ; substr : ignore le premier (1) caractère de la chaine ; strtolower : tout en minuscule */ 
                    if (in_array($extension_upload, $extensions_valides)) 
                    {
                        $chemin = "images/".$_FILES['fic']['name'].".".$extension_upload;
                        $resultat = move_uploaded_file($_FILES['fic']['tmp_name'], $chemin);
                        if ($resultat) 
                        {
                            $img_nom  = $_FILES['fic']['name'];
                            $img_type = $_FILES['fic']['type'];
                            $img_taille = $_FILES['fic']['size'];
                            $img_user_id = $_SESSION['id'];
                            $img_user_login = $_SESSION['login'];
                            $img_user_photos = $_SESSION['photos'];
                            $date = date('Y/m/d'); 
                            $img_lieu = 0;

                            $insertimage = $bdd -> prepare("INSERT INTO  images(nom, taille, type, id_user, login_user, date_publication, lieu) VALUES (?, ?, ?, ?, ?, ?, ?)");
                            $insertimage -> execute(array($img_nom, $img_taille, $img_type, $img_user_id, $img_user_login, $date, $img_lieu));


                            $photos = $bdd ->query('UPDATE membre SET photos=photos+1 WHERE id = '.$_SESSION['id']);

                                /*$num_rows = mysql_num_rows($insertimage);
                                echo $num_rows;*/
                            header("Location: Mes_photos.php?id=".$_SESSION['id']);
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
            $msg = "Votre photo de profil ne doit pas dépasser 3 Mo !";
        }
    }
}

$reqimages = $bdd ->query('SELECT * FROM images WHERE id_user = '.$_SESSION['id'].' ORDER BY id DESC');

if (isset($_POST['supprimer'])) 
{
   for ($i=0;$i<count($_POST['supprimer']);$i++)
    {
        $choix = $_POST['supprimer'][$i];        
        $supprimage = $bdd ->query('DELETE FROM images WHERE id = '.$choix);
        $photos = $bdd ->query('UPDATE membre SET photos=photos-1 WHERE id = '.$_SESSION['id']);
        header("Location: Mes_photos.php?id=".$_SESSION['id']);
     }
}

if (isset($_POST['modifier'])) 
{
   for ($i=0;$i<count($_POST['modifier']);$i++)
    {
        $choix = $_POST['modifier'][$i];
        $reqimages = $bdd ->query('SELECT * FROM images WHERE id='.$choix);
        $data = $reqimages->fetch();
        header("Location: Mes_photos.php?id=".$_SESSION['id']);
     }
}

?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

        <script src="..\JS\jquery.magnific-popup.js"></script>
        <link rel="stylesheet" href="..\CSS\magnific-popup.css">
        
        <title>Mes photos</title>
    </head>

    <body>
    	
    	<div id="header">
            <table id="header_table"><tr><td id="header_td">
                <ul id="menu">
                     <?php
                    if (isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) 
                    {
                        ?>
                    <li id="accueil"><a href="Accueil.php"><img src="../images/home.png" id="home_ico" />Accueil</a></li>
                    <li id="profil"><a href="Profil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/people.png" id="people_ico" />Mon profil</a></li>
                    <li id="parametres"><a href="Parametres.php"><img src="../images/parametres.png" id="parametres_ico" />Paramètres</a></li>
                    <li id="deconnexion"><a href="Deconnexion.php" onClick="deconnexion()"><img src="../images/deconnexion.png" id="deconnexion_ico" onClick="deconnexion()" /> Se déconnecter</a></li>
                    <?php
                    }
                     ?>
                </ul>
            </td></tr></table>
        </div>


        <div id="contenu">    
            <table id="contenu_table"><tr><td id="contenu_td">

                <div id="options">
                    <table id="options_table"><tr><td id="options_td">
                        <ul>
                            <li id="ajouter"><p class="ajouter"><img src="../images/ajouter_2.png" id="ajouter_ico" class="ajouter" />ajouter</p></li>
                            <li id="supprimer"><p class="supprimer_bouton"><img src="../images/supprimer.png" id="supprimer_ico" class="supprimer_bouton" />supprimer</p></li>
                            <li id="modifier"><p class="modifier_bouton"><img src="../images/modifier.png" id="modifier_ico" />modifier</p></li>
                        </ul>
                    </td></tr></table>
                </div>

                <div class="ajout">
                    <?php
                        if (isset($msg)) 
                        {
                            echo $msg;
                        }
                    ?>
                    <form enctype="multipart/form-data" action="" method="POST">
                     <input type="file" name="fic" value="" />
                     <input type="submit" value="Envoyer" name="bouton" />
                     </form>
                </div>
               
                       <div class="galleriePhotos-Zoom">
                <table id="photos_table">

                        <?php

                         while ($data = $reqimages->fetch())
                        {           
                            
                        ?>

                        <tr>
                            <td id="images_checkbox_supprimer_td">
                                <form method="POST" action=""><input type="checkbox" name="supprimer[]" class="supprimer" value="<?php echo $data['id'] ?>"></input>
                            </td>
                            <td id="images_checkbox_modfier_td">
                                <form method="POST" action=""><input type="checkbox" name="modifier[]" class="modifier" value="<?php echo $data['id'] ?>"></input>
                            </td>
                            <td id="photos_td" class="barre"><a href="images/<?php echo $data['nom']; ?>" class="a_images" titrePhoto="<?php echo $data['nom']; ?>">
                            <img src="images/<?php echo $data['nom']; ?>" class="images"/></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                        <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                        <li><img src="../images/cadenas.png" id="cadenas_ico" class="cadenas"/></li>
                                        <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                            </td>
                        </tr>
                    
                        <?php
                            }

                            $reqimages -> closeCursor();
                        ?> 

                    <input type="submit" value="valider" class="valider"></input></form> <input type="button" value="annuler" class="annuler"></input>
                </form>

                </table>
                </div>

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

    <script type="text/javascript" src="..\JS\profil.js">
    </script>

</head>


<?php
}

?>
