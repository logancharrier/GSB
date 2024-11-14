<?php
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lstMois'])) {
//    
?>

<div class="row" style="margin-left: 0px">

    <h2 style="color: #ff8800">Valider la fiche de frais</h2>

    <h3>Éléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" 
              action="index.php?uc=validerFrais&action=validerMajFraisForfait" 
              role="form">
            <fieldset>
                <?php
                $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
                $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $lesFraisForfait = getLesFraisForfait($idVisiteurAValider, $leMois);

                foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = htmlspecialchars($unFrais['libelle']);
                    $quantite = $unFrais['quantite'];
                    ?>
                    <div class="form-group">
                        <label for="idFrais"><?php echo $libelle ?></label>
                        <input type="text" id="idFrais" 
                               name="lesFrais[<?php echo $idFrais ?>]"
                               size="10" maxlength="5" 
                               value="<?php echo $quantite ?>" 
                               class="form-control">
                    </div>
                    <?php
                }
                ?>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Réinitialiser</button>
            </fieldset>
        </form>
    </div>

</div>

<?php
//}
// 
?>
<hr>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            Descriptif des éléments hors forfait
        </h3>
    </div>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th> 
            </tr>
        </thead>  
        <tbody>
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id'];
                ?>           
                <tr>
                    
                    <td><input type="text" id="dateFrais" 
                               value="<?php echo $date ?>" 
                               class="form-control"></td>
                    <td><input type="text" id="libelleFrais" 
                               value="<?php echo $libelle ?>" 
                               class="form-control"></td>
                    <td><input type="number" id="montantFrais" 
                               value="<?php echo $montant ?>" 
                               class="form-control"></td>
                    <td>
                        <button class="btn btn-success" type="submit">Corriger</button>
                        <button class="btn btn-danger" a href="index.php?uc=validerFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
                           onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Réinitialiser</button>
                    </td>
                </tr>
    <?php
}
?>
        </tbody>  
    </table>
</div>

<strong>
    <h6>Nombre de justifications :<input type="number" id="montantFrais" 
                               value="<?php echo $nbJustificatifs ?>" 
                               class="form-control"></h6><br>
<button class="btn btn-success" type="submit">Valider</button>
<button class="btn btn-danger" type="reset">Réinitialiser</button>
