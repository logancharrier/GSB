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
<hr>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Descriptif des éléments hors forfait</h3>
    </div>
    <form method="post" action="index.php?uc=validerFrais&action=validerMajFraisHorsForfait">
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
                        <td><input type="text" name="frais[<?php echo $id ?>][date]" 
                                   value="<?php echo $date ?>" 
                                   class="form-control"></td>
                        <td><input type="text" name="frais[<?php echo $id ?>][libelle]" 
                                   value="<?php echo $libelle ?>" 
                                   class="form-control"></td>
                        <td><input type="number" name="frais[<?php echo $id ?>][montant]" 
                                   value="<?php echo $montant ?>" 
                                   class="form-control"></td>
                        <td>
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <a class="btn btn-danger" href="index.php?uc=validerFrais&action=refuserFrais&idFrais=<?php echo $id ?>" 
                               onclick="return confirm('Voulez-vous vraiment refuser ce frais?');">Refuser</a>
                            <a class="btn btn-info" href="index.php?uc=validerFrais&action=reporterFrais&idFrais=<?php echo $id ?>" 
                               onclick="return confirm('Voulez-vous vraiment reporter ce frais?');">Reporter</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>  
        </table>
    </form>

</div>


<form method="post" action="index.php?uc=validerFrais&action=validerFiche">
    <strong>
        <h6>Nombre de justificatifs :</strong>
        <input type="number" name="nbJustificatifs" size="10" maxlength="10" id="nbJustifications" 
               value="<?php echo $nbJustificatifs ?>" class="form-control">
        </h6><br>
    <button class="btn btn-success" type="submit">Valider</button>
    <button class="btn btn-danger" type="reset">Réinitialiser</button>
</form>

