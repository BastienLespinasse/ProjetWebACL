<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_GET['id']) AND $_GET['id'] > 0) 
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
    $requser -> execute(array($getid));
    $userinfo = $requser -> fetch();

    $reqimages = $bdd ->query('SELECT * FROM images WHERE id_user = '.$_SESSION['id'].' ORDER BY id DESC LIMIT 3');
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

        <script src="..\JS\jquery.magnific-popup.js"></script>
        <link rel="stylesheet" href="..\CSS\magnific-popup.css">
        
        <title>Mon profil</title>
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
                    <li id="deconnexion"><a href="Deconnexion.php" onClick="deconenxion()"><img src="../images/deconnexion.png" id="deconnexion_ico" onClick="deconnexion()" /> Se déconnecter</a></li>
                    <?php
                    }
                     ?>
                </ul>
            </td></tr></table>
        </div>

        <div id="contenu">    
            <table id="contenu_table"><tr><td id="contenu_td">
                
                <div id="infos">
                    <table id="infos_table">
                        <tr id="infos_tr">
                            <td id="infos_photo">
                                <div class="gallerieAvatar-Zoom">
                                <a href="avatars/<?php echo $userinfo['avatar']; ?>" titrePhoto="<?php echo $userinfo['prenom']; ?> <?php echo $userinfo['nom']; ?>">
                                    <img src="avatars/<?php echo $userinfo['avatar']; ?>"  class="photo_profil" id="photo_profil" /></a>
                                </div>
                            </td>
                            <td id="infos_texte">
                                <ul id="prenom_nom">
                                        <li><?php echo $userinfo['prenom'];  ?></li>
                                        <li><?php echo $userinfo['nom'];  ?></li>
                                </ul>
                                <ul id="icones_infos">
                                    <li><a href="Mes_photos.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/photo.png" id="photo_ico" /></a></li>
                                    <li><a href="Mes_albums.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/album.png" id="album_ico" /></a></li>
                                    <li><a href="Mes_amis.php"><img src="../images/amis.png" id="amis_ico" /></a></li>
                                    <?php
                                        if (isset($_SESSION['id']) AND $userinfo['admin'] == 1) 
                                        {
                                     ?>
                                    <li><a href="Admin.php"><img src="../images/admin.png" id="admin_ico" /></a></li>
                                    <?php
                                        }
                                        else
                                        {
                                            ?>
                                             <li><a href="Profil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/admin.png" id="admin_ico" style="opacity: 0.3" /></a></li>
                                        <?php
                                        }
                                    ?>
                                </ul>
                                <ul id="texte_infos" >
                                    <li><a href="Mes_photos.php?id=<?php echo $_SESSION['id'] ?>">Mes photos</a></li>
                                    <li><a href="Mes_albums.php">Mes albums</a></li>
                                    <li><a href="Mes_amis.php">Mes amis</a></li>
                                    <?php
                                        if (isset($_SESSION['id']) AND $userinfo['admin'] == 1) 
                                        {
                                     ?>
                                    <li><a href="Admin.php">Espace administrateur</a></li>
                                    <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li><a href="Profil.php?id=<?php echo $_SESSION['id'] ?> "style="opacity: 0.3">Espace administrateur</a></li>
                                             <?php
                                        }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                    </table>
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
                                        <li><a class="popup-with-zoom-anim" href="#small-dialog"><img src="../images/info.png" id="info_ico" /></a></li>
                                        <div id="small-dialog" class="zoom-anim-dialog mfp-hide">
                                          <?php echo $data['nom']; ?>
                                        </div>

                                        
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

</html>

<?php
}
?>