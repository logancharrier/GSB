<?php
    // Enregistrer l'id du visiteur dans la session
    //$_SESSION['idVisiteur'] = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    ?>
    <form action="index.php?uc=validerFicheDeFrais&action=ValiderFrais" method="POST">
       
    <div class="inline">
            <label for="lstMois" accesskey="n">Mois : </label>
            <select id="lstMois" name="lstMois" class="form-control">
                <?php
                $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
                $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $lesMois = $pdo->getLesMoisDisponibles($idVisiteurAValider);
                $moisASelectionner = $leMois;

                foreach ($lesMois as $unMois) {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                    ?>
                    <option value="<?php echo htmlspecialchars($mois); ?>" <?php echo $mois == $moisASelectionner ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($numMois . '/' . $numAnnee); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <input type="submit" value="Valider">
        </form>
    </div>
    <?php