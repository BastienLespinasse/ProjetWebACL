<!DOCTYPE>

<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre', 'root', '');

if(!empty($_FILES))
{
    $img = $_FILES['img'];
    $ext = strtolower(substr($img['name'], -3));
    $allow_ext = array('jpg', 'png', 'gif');
    if (in_array($ext, $allow_ext)) 
    {
        move_uploaded_file($img['tmp_name'], "images/".$img['name']);    
    }
    else
    {
        $msg = "Votre fichier n'est pas une image.";
    }
    
}

?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="..\CSS\profil.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        
        <title>Mes photos</title>
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

            <?php
                if (isset($msg)) 
                {
                    echo $msg;
                }
            ?>
            <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" name="img"></input>
            <input type="submit" name="envoyer"></input>
            </form>

            <?php
                $dos = "images";
                $dir = opendir($dos);
                while ($file = readdir($dir)) 
                {
                    $allow_ext = array('jpg', 'png', 'gif');
                    $ext = strtolower(substr($file, -3));
                    if (in_array($ext, $allow_ext)) 
                    {
                        ?>
                        <img src="images/<?php echo $file ; ?>"/>
                        <?php
                    }
                }
            ?>

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
