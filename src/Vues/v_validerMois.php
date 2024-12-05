<?php 

?>

<form action="index.php?uc=validerFrais&action=voirEtatFrais" id="inlineBlock" method="POST">

    <div class="inline" id="flex">
        <label for="lstMois" accesskey="n">Mois&nbsp;:&nbsp;</label>
        <select id="lstMois" name="lstMois" class="form-control">
            <?php
            foreach ($lesMois as $unMois) {
                if ($unMois === null) {
                    // Si $unMois est nul, utilisez $moisASelectionner
                    $mois = $moisASelectionner;
                    $numAnnee = substr($moisASelectionner, 0, 4); // Extrait l'année
                    $numMois = substr($moisASelectionner, 4, 2); // Extrait le mois
                } else {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                }
                ?>
                <option value="<?php echo htmlspecialchars($mois); ?>" <?php echo $mois === $moisASelectionner ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($numMois . '/' . $numAnnee); ?>
                </option>
                <?php
            }
            ?>
        </select>
        <input class="btn btn-success" type="submit" value="Valider">
    </div>
</form>
