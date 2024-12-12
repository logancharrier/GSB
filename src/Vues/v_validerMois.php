<form action="index.php?uc=validerFrais&action=voirEtatFrais" id="inlineBlock" method="POST">

    <div class="inline" id="flex">
        <label for="lstMois" accesskey="n">Mois&nbsp;:&nbsp;</label>
        <select id="lstMois" name="lstMois" class="form-control">
            <?php
            if (empty($lesMois)) {
            ?>
                <option disabled selected>Pas de fiche de frais disponible</option>
                <?php
            } else {
                foreach ($lesMois as $unMois) {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];

                    // Vérification si ce mois est sélectionné
                    $selected = ($mois === $moisASelectionner) ? 'selected' : '';
                ?>
                    <option value="<?php echo htmlspecialchars($mois); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($numMois . '/' . $numAnnee); ?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
        <?php
        if (!empty($lesMois)) {
        ?>
            <input class="btn btn-success" type="submit" value="Valider">
        <?php
        }
        ?>
    </div>
</form>