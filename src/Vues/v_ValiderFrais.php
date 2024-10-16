<div>
    <label for="input-visiteur">Choisir le visiteur : </label>
    <form action="" method="POST">
        <select id="visiteurs" name="idVisiteur">
            <?php
            $pdo2 = new PDO('mysql:host=localhost;dbname=gsb_frais', 'userGsb', 'secret');
            $pdo2->query('SET CHARACTER SET utf8');
            $lesVisiteurs = getLesVisiteurs($pdo2);
            $idVisiteurSelectionne = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Récupérer le visiteur sélectionné
            foreach ($lesVisiteurs as $unVisiteur) {
                $nom = $unVisiteur['nom'];
                $prenom = $unVisiteur['prenom'];
                $id = $unVisiteur['id'];
                ?>
                <option value="<?php echo htmlspecialchars($id); ?>" <?php echo $id === $idVisiteurSelectionne ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($nom . ' ' . $prenom); ?>
                </option>
            <?php
            }
            ?>
        </select>

        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois" class="form-control">
            <?php
            $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idVisiteur = $_SESSION['idVisiteur'];
            $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
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
// Afficher la div seulement si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idVisiteur']) && isset($_POST['lstMois'])) {
    ?>
    <div>
        <h2>Valider la fiche de frais</h2>
        <h3>Éléments forfaitisés</h3>
        <?php
        $idVisiteur = filter_input(INPUT_POST, 'idVisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lesFraisForfait = getLesFraisForfait($idVisiteur, $leMois);

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