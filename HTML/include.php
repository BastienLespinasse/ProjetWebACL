<table id="photos_table">

                        <?php
                        $reqimages = $bdd ->query('SELECT * FROM images ORDER BY id WHERE id = $_SESSION['id']');

                         while ($data = $reqimages->fetch())
                        { 
                            
                        ?>

                        <tr>
                            <td id="images_checkbox_td">
                                <form method="POST" action=""><input type="checkbox" name="supprimer[]" class="supprimer" value="<?php echo $data['id'] ?>"></input>
                            </td>
                            <td id="photos_td" class="barre"><img src="images/<?php echo $_SESSION['id'] ?>.<?php echo $data['nom']; ?>" class="images"/>
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
