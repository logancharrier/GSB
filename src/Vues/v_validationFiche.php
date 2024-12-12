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
            <input type="hidden" name="moisASelectionner" value="<?php echo $_SESSION['moisASelectionner']; ?>">
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
    <form method="post" action="index.php?uc=validerFrais&action=validerMajFraisHorsForfait" onsubmit="return validateDates();">
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
                               class="form-control" id="date_<?php echo $id ?>"></td>
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
        <h6>Nombre de justificatifs :
    </strong>
    <input type="number" name="nbJustificatifs" size="10" maxlength="10" id="nbJustifications"
        value="<?php echo $nbJustificatifs ?>" class="form-control">
    </h6><br>
    <button class="btn btn-success" type="submit">Valider</button>
    <button class="btn btn-danger" type="reset">Réinitialiser</button>
</form>
<?php
echo '<script>
    // Script permettant de garder la position du scroll dans la page après redirection
    window.onload = function() {
        if (sessionStorage.getItem("scrollPosition")) {
            window.scrollTo(0, sessionStorage.getItem("scrollPosition"));
        }
    }

    window.onbeforeunload = function() {
        sessionStorage.setItem("scrollPosition", window.scrollY);
    }
</script>'; ?>

<!-- Icône de validation (masquée par défaut) -->
<div id="validationIcon" style="display: none; position: absolute; right: 10px; top: 10px;">
    <i class="fa fa-check-circle" style="color: green; font-size: 24px;"></i>
</div>

<script>
    function validateDates() {
        // Expression régulière pour valider le format de la date (jj/mm/aaaa)
        var dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
        
        // Récupérer la date d'aujourd'hui
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Réinitialiser l'heure pour comparer uniquement la date
        
        // Vérifier chaque champ de date
        var valid = true;
        var dateInputs = document.querySelectorAll('[id^="date_"]');
        
        dateInputs.forEach(function(input) {
            var dateValue = input.value.trim();
            
            // Vérification du format de la date
            if (!dateRegex.test(dateValue)) {
                alert("Veuillez entrer une date valide (format: dd/mm/yyyy).");
                valid = false;
                input.style.borderColor = 'red'; // Mettre la bordure en rouge pour indiquer une erreur
            } else {
                // Convertir la date entrée en format Date pour la comparer avec aujourd'hui
                var parts = dateValue.split('/');
                var enteredDate = new Date(parts[2], parts[1] - 1, parts[0]); // Convertir dd/mm/yyyy en Date
                
                // Vérification si la date est ultérieure à aujourd'hui
                if (enteredDate > today) {
                    alert("La date ne peut pas être ultérieure à la date d'aujourd'hui.");
                    valid = false;
                    input.style.borderColor = 'red'; // Mettre la bordure en rouge pour indiquer une erreur
                } else {
                    input.style.borderColor = ''; // Réinitialiser la bordure si la date est valide
                }
            }
        });
        
        return valid; // Retourne false si une date est invalide (empêche la soumission)
    }
</script>

