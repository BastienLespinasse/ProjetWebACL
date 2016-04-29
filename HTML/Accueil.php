<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
if (isset($_SESSION['id'])) 
{
    $requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
    $requser -> execute(array($_SESSION['id']));
    $userinfo = $requser -> fetch();

$reqimages = $bdd ->query('SELECT * FROM images WHERE visibilite="publique"');

if (isset($_POST['aimer'])) 
{
       for ($i=0;$i<count($_POST['aimer']);$i++)
        {
            $choix = $_POST['aimer'][$i]; 
            $jaime = $bdd ->query('UPDATE images SET jaime=jaime+1 WHERE id = '.$choix);  
            header("Location: Accueil.php");     
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
        
        <title>Accueil</title>
    </head>

    <body>
    	
    	<div id="header">
            <table id="header_table"><tr><td id="header_td">
                <ul id="menu">
                    <?php
                    if (isset($_SESSION['id'])) 
                    {
                        ?>
                    <li id="accueil"><a href="Accueil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/home.png" id="home_ico" />Accueil</a></li>
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

                 <div class="galleriePhotos-Zoom">
                <table id="photos_table">

                        <?php

                         while ($data = $reqimages->fetch())
                        {           
                            
                        ?>

                        <tr>
                            <td id="photos_td" class="barre"><a href="images/<?php echo $data['nom']; ?>" class="a_images" titrePhoto="<?php echo $data['nom']; ?>">
                            <img src="images/<?php echo $data['nom']; ?>" class="images"/></a>
                            <div id="barre">
                                <ul id="barre_tache">
                                        <li><form method="POST" action=""><input type="image" name="aimer[]" img src="../images/jaime_blanc.png" id="jaime_ico" class="coeur" value="<?php echo $data['id'] ?>"></input></form></li>
                                        <li><img src="../images/punaise.png" id="punaise_ico" class="punaise"/></li>
                                        <li><div class="info_ico"><img src="../images/info.png" id="info_ico" /></div></li> 
                                        <div class="infos_photo">
                                            <div class="fermer_infos"><img src="../images/deconnexion_rouge.png" class="fermer_infos_bouton" /></div>
                                            <?php echo "Nom : ".$data['nom'] ?></br>
                                            <?php echo "Auteur : ".$data['login_user']?></br>
                                            <?php echo "Date de publication : ".$data['date_publication']?></br>
                                            <?php echo "Lieu : ".$data['lieu'] ?></br>
                                            <?php echo "Thème : ".$data['theme'] ?></br>
                                            <?php echo "Personnes présentes : ".$data['personnes_presentes'] ?></br>
                                            <?php echo "Nombre de jaimes : ".$data['jaime'] ?></br>
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

<?php
}
?>
