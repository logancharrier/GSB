<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lstMois'])) {
    
    ?>
    <div>
        <h2>Valider la fiche de frais</h2>
        <h3>Éléments forfaitisés</h3>
        <?php
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lesFraisForfait = getLesFraisForfait($idVisiteurAValider, $leMois);
        
        foreach ($lesFraisForfait as $leFraisForfais) { ?>
            <p><?php echo htmlspecialchars($leFraisForfais['libelle']); ?></p>
            <input value="<?php echo htmlspecialchars($leFraisForfais['quantite']); ?>">
        <?php
        }
        ?>
    </div>
    <?php
}
?>
