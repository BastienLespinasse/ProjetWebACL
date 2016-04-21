<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');



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
                    if (isset($_SESSION['id'])) 
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

                <table id="photos_table">
                    <tr id="photos_tr">
                        <td id="photos_td" class="barre">
                            <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                            <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                           <div id="barre">
                               <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                         <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                         <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                         <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                         <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <tr id="photos_tr">
                        <td id="photos_td" class="barre">
                            <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                            <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                               <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                         <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                        <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
                                    <li><img src="../images/info.png" id="info_ico" /></li>
                                </ul>
                            </div>
                        </td>
                        <td id="photos_td" class="barre">
                         <a href="#image_grand" class="a_images"><img src="../images/image2.jpg" class="images" /></a>
                        <a href="#_" class="lightbox" id="image_grand"><img src="../images/image2.jpg" class="images" /></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                    <li><img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur"/></li>
                                    <li><img src="../images/punaise.png" id="link_ico" class="punaise"/></li>
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

