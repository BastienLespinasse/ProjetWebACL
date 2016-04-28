<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if (isset($_SESSION['id'])) /* si une personne est connectée */
{
    $requser = $bdd -> prepare("SELECT * FROM membre WHERE id =?");
    $requser -> execute(array($_SESSION['id']));
    $user = $requser -> fetch();

    $reqimages = $bdd ->query('SELECT * FROM images');
    $data = $reqimages->fetch();
    
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <title>Paramètres   </title>
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
            <form method="POST" action="" enctype="multipart/form-data">            
                <table id="parametres_table">
                    <tr id="parametres_tr">
                        <td>Nom</td>
                        <td><?php echo $data['nom'];?></td>
                        <td><img src="../images/modifier.png" id="modifier_ico" class="img" /></td>
                        <td><div id="modif_prenom" class="modif"><input id="theme" placeholder="<?php echo $data['lieu'];?>" name="new_thème" class="0" onBlur="verif_prenom(prenom)" ><input type="image" src="../images/valider.png" value="ok" class="ok_modif" /><img src="../images/deconnexion_rouge.png" class="fermer_modif" /></div></td>
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