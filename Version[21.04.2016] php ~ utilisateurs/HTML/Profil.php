<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_GET['id']) AND $_GET['id'] > 0) 
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
    $requser -> execute(array($getid));
    $userinfo = $requser -> fetch();
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
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
                    <li id="deconnexion"><a href="Deconnexion.php" onClick="deconnexion()"><img src="../images/deconnexion.png" id="deconnexion_ico" onClick="deconnexion()" /> Se déconnecter</a></li>
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
                                <a href="#photo_profil_grand">
                                <img src="avatars/<?php echo $userinfo['avatar'];?>"  class="photo_profil" id="photo_profil" /></a>
                                <a href="#_" class="lightbox" id="photo_profil_grand"><img src="avatars/<?php echo $userinfo['avatar']; ?>"></a>
                            </td>
                            <td id="infos_texte">
                                <ul id="prenom_nom">
                                        <li><?php echo $userinfo['prenom'];  ?></li>
                                        <li><?php echo $userinfo['nom'];  ?></li>
                                </ul>
                                <ul id="icones_infos">
                                    <li><a href="Mes_photos.php"><img src="../images/photo.png" id="photo_ico" /></a></li>
                                    <li><a href="Mes_albums.php"><img src="../images/album.png" id="album_ico" /></a></li>
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
                                    <li><a href="Mes_photos.php">Mes photos</a></li>
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


                <table id="photos_table">
                    <tr id="photos_tr">
                        <td id="photos_td" class="barre">
                        <a href="#image1_grand" class="a_images"><img src="../images/image1.jpg" class="images" /></a>
                        <a href="#_" class="lightbox" id="image1_grand"><img src="../images/image1.jpg" class="images" /></a>
                           <div id="barre">
                               <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/cadenas.png" id="cadenas_ico" class="cadenas"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                        <a href="#image2_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                        <a href="#_" class="lightbox" id="image2_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/cadenas.png" id="cadenas_ico" class="cadenas"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                        <a href="#image3_grand" class="a_images"><img src="../images/image3.jpg" class="images" /></a>
                        <a href="#_" class="lightbox" id="image3_grand"><img src="../images/image3.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/cadenas.png" id="cadenas_ico" class="cadenas"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </table>
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