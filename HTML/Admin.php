<!DOCTYPE>

<?php
session_start();


$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');
$reqamis = $bdd ->query('SELECT * FROM membre ORDER BY nom');

$requser = $bdd -> prepare("SELECT * FROM membre WHERE id =?");
$requser -> execute(array($_SESSION['id']));
$user = $requser -> fetch();

if (isset($_POST['supprimer'])) 
{
   for ($i=0;$i<count($_POST['supprimer']);$i++)
    {
        $choix = $_POST['supprimer'][$i];
        if ($choix != $_SESSION['id']) 
        {
            $suppramis = $bdd ->query('DELETE FROM membre WHERE id = '.$choix);
            header("Location: Admin.php");
        }
        else
        {
            
        }
        
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

        <title>Espace administrateur</title>
    </head>

    <body>
        
        <div id="header">
            <table id="header_table"><tr><td id="header_td">
                <ul id="menu">
                    <li id="accueil"><a href="Accueil.php"><img src="../images/home.png" id="home_ico" />Accueil</a></li>
                    <li id="profil"><a href="Profil.php?id=<?php echo $_SESSION['id'] ?>"><img src="../images/people.png" id="people_ico" />Mon profil</a></li>
                    <li id="parametres"><a href="Parametres.php"><img src="../images/parametres.png" id="parametres_ico" />Paramètres</a></li>
                    <li id="deconnexion"><a href="Deconnexion.php" onClick="deconnexion()"><img src="../images/deconnexion.png" id="deconnexion_ico" onClick="deconnexion()" /> Se déconnecter</a></li>
                </ul>
            </td></tr></table>
        </div>


        <div id="contenu">    
            <table id="contenu_table"><tr><td id="contenu_td">

                <div id="options">
                    <table id="options_table"><tr><td id="options_td">
                        <ul>
                            <li id="ajouter"><a href="#"><img src="../images/ajouter_2.png" id="ajouter_ico" />ajouter</a></li>
                            <li id="supprimer"><p class="supprimer_bouton"><img src="../images/supprimer.png" id="supprimer_ico" class="supprimer_bouton" />supprimer</p></li>
                        </ul>
                    </td></tr></table>
                </div>

                <table id="amis_table">
                       <?php
                            while($data = $reqamis->fetch()) /*tant qu'il y a des données*/
                                {
                        ?>
                        <tr id="amis_tr">
                            <td id="amis_photo_td">
                                <div class="gallerieAvatar-Zoom">
                                <a href="avatars/<?php echo $data['avatar']; ?>" titrePhoto="<?php echo $data['prenom']; ?> <?php echo $data['nom']; ?>">
                                    <img src="avatars/<?php echo $data['avatar']; ?>"  class="photo_profil" id="photo_profil_amis" /></a>
                                </div>
                            </td>
                            <td id="amis_prenom_td">
                                <a href="#"><?php echo $data['prenom']; ?></a>
                            </td>
                            <td id="amis_nom_td">
                                <a href="#"><?php echo $data['nom']; ?></a>
                            </td>
                            <td class="amis_infos_td">
                                <img src="../images/info.png" class="info_ico_amis" />
                            </td>
                            <td id="amis_checkbox_td">
                                <form method="POST" action=""><input type="checkbox" name="supprimer[]" class="supprimer" value="<?php echo $data['id'] ?>"></input>
                            </td>
                            <td class="amis_infos_box_td">
                                <table class="parametres_table_admin">
                                <tr id="fermer_tr">
                                    <td><img src="../images/deconnexion.png" class="fermer_infos" /></td>
                                </tr>
                                <tr id="parametres_tr">
                                    <td>Date de naissance</td>
                                    <td><?php echo $data['date_naissance']; ?></td>
                                </tr>
                                <tr id="parametres_tr">
                                    <td>Adresse e-mail</td>
                                    <td><?php echo $data['mail'];?></td>
                                </tr>
                                <tr id="parametres_tr">
                                    <td>Nombre de photos</td>
                                    <td><?php echo $data['photos'];?></td>
                                </tr>
                                <tr id="parametres_tr">
                                    <td>Nombre d'albums</td>
                                    <td><?php echo $data['albums'];?></td>
                                </tr>  
                            </table>
                            </td>
                        </tr>
                        <?php
                                 }

                                 
                                     $reqamis -> closeCursor();
                                ?>

                                <input type="submit" value="valider" class="valider"></input></form> <input type="button" value="annuler" class="annuler"></input></form>

                        </table>

            </td></tr></table></br></br></br></br></br></br>
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