<div class="inline">
    <label for="input-visiteur">Choisir le visiteur : </label>
    <form class="inline" action="index.php?uc=validerFrais&action=selectionnerMois" method="POST">
        <select id="visiteursAValider" name="idVisiteurAValider">
            <?php
            $pdo2 = new PDO('mysql:host=localhost;dbname=gsb_frais', 'userGsb', 'secret');
            $pdo2->query('SET CHARACTER SET utf8');
            $lesVisiteurs = getLesVisiteurs($pdo2);
            
           if (! isset($_POST['idVisiteurAValider'])){
                $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
                echo $idVisiteurAValider . " --! isset--";
            }
            else{
                $_SESSION['idVisiteurAValider']=filter_input(INPUT_POST, 'idVisiteurAValider', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Récupérer le visiteur sélectionné
                $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
                echo $idVisiteurAValider . " --isset --";
            }
            foreach ($lesVisiteurs as $unVisiteur) {
                $nom = $unVisiteur['nom'];
                $prenom = $unVisiteur['prenom'];
                $id = $unVisiteur['id'];
                ?>
                <option value="<?php echo htmlspecialchars($id); ?>" <?php echo $id === $idVisiteurAValider ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($nom . ' ' . $prenom); ?>
                </option>
            <?php
            }
            ?>
        </select>
        <input class="btn btn-success" type="submit" value="Suivant">
    </form>
        
        

</div>