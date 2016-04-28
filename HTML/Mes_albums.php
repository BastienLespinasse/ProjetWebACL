<!DOCTYPE>

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_GET['id']) AND $_GET['id'] > 0) 
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
    $requser -> execute(array($getid));
    $userinfo = $requser -> fetch();


if (isset($_SESSION['id'])) /* si une personne est connectée */
{
 if (isset($_POST['bouton'])) 
    {
        $album_titre = htmlspecialchars($_POST['album_titre']); /* on sécurise notre variable */
        $date = date('Y/m/d');
        $album_user_id = $_SESSION['id'];
        $album_user_login = $_SESSION['login'];

        $inserttitre = $bdd -> prepare("INSERT INTO albums(titre, date_publication, nombre_photos, id_user, login_user, photo_album) VALUES (?, ?, ?, ?, ?, ?)");
        $inserttitre -> execute(array($album_titre, $date, 0, $album_user_id, $album_user_login, 0));

        header("Location: Mes_albums.php?id=".$_SESSION['id']);
 
    }

    if (isset($_FILES['photo_album']) AND !empty($_FILES['photo_album']['name'])) 
    {
        $taille_max = 2097152; /*taille max de l'image uploadée */
        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png'); /*formats supportés */

        if ($_FILES['photo_album']['size'] <= $taille_max) /* si l'image n'est pas trop grande */
        {
            $extension_upload = strtolower(substr(strrchr($_FILES['photo_album']['name'], "."), 1)); /*strrchr : renvoit l'extension du fichier ; substr : ignore le premier (1) caractère de la chaine ; strtolower : tout en minuscule */ 
            if (in_array($extension_upload, $extensions_valides)) 
            {
                $chemin = "photos_albums/".$_SESSION['id'].".".$extension_upload;
                $resultat = move_uploaded_file($_FILES['photo_album']['tmp_name'], $chemin);

                if ($resultat) 
                {
                    $update_avatar = $bdd -> prepare('UPDATE albums SET photo_album = :photo_album WHERE id = :id');
                    $update_avatar -> execute(array(
                        'photo_album' => $_SESSION['id'].".".$extension_upload,
                        'id' => $_SESSION['id']
                        ));
                     header("Location: Mes_albums.php?id=".$_SESSION['id']);
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
}

$reqalbums = $bdd ->query('SELECT * FROM albums WHERE id_user = '.$_SESSION['id']);
    
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <title>Mes albums</title>
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

                <div id="options">
                    <table id="options_table"><tr><td id="options_td">
                        <ul>
                            <li id="ajouter"><p class="ajouter_album"><img src="../images/ajouter_2.png" id="ajouter_ico" class="ajouter_album" />ajouter</p></li>
                            <li id="supprimer"><a href="#"><img src="../images/supprimer.png" id="supprimer_ico" />supprimer</a></li>
                            <li id="modifier"><a href="#"><img src="../images/modifier.png" id="modifier_ico" />modifier</a></li>
                        </ul>
                    </td></tr></table>
                </div>

                <div class="ajout_album">
                <form method="POST" action="">            
                <table id="album_table">
                    <tr id="album_tr">
                        <td>Titre</td>
                        <td></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="titre" class="ajout"><input id="titre" placeholder="titre" name="album_titre" class="0"><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>
                    <tr id="album_tr">
                        <td><a href="#photo_profil_amis_grand"><img src=""  class="photo_profil" id="photo_profil_amis" /></a></td>
                        <td>Photo de l'album</td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_mdp" class="modif"><input type="file" name="photo_album" id="modifier_avatar" value=""><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
                    </tr>  
                    </table>
                    </br></br></br><input type="submit" value="Valider" id="bouton" name="bouton" />      
                </form>
                </div>

                </br></br>
                <table id="albums_table">
                    <?php
                        while($data = $reqalbums->fetch()) /*tant qu'il y a des données*/
                            {
                    ?>
                    <tr id="albums_tr">
                        <td id="albums_photo_td">
                            <!--<a href="#photo_profil_amis_grand"><img src="avatars/<?php echo $data['avatar']; ?>"  class="photo_profil" id="photo_profil_amis" /></a>
                            <a href="" class="lightbox" id="photo_profil_amis_grand"><img src="avatars/<?php echo $data['avatar']; ?>"></a>-->
                        </td>
                        <td id="albums_titre_td">
                            <a href="#"><?php echo $data['titre']; ?></a>
                        </td>
                    </tr>
                    <?php
                             }

                                 $reqalbums -> closeCursor();
                            ?>
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

</html>

<?php
}

?>
