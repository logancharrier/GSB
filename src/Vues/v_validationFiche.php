<?php
/**
 * Vue Liste des mois
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 * @link      https://getbootstrap.com/docs/3.3/ Documentation Bootstrap v3
 */
?>
<hr>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            Descriptif des éléments hors forfait
        </h3>
    </div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>  
            <th class='etat'></th>
        </tr>
        <tr>
            <td><input type="date" id="txtDate" name="dateFrais" id="text"></td>
            <td><input type="text" id="txtLibelle" name="libelle" id="text"></td>
            <td><input type="number" id="txtMontant" name="montant" id="number"></td>
            <td>
                <button class="btn btn-success" type="submit">Corriger</button>
                <button class="btn btn-danger" type="reset">Réinitialiser</button>
            </td>
        </tr>


    </table>


</div>

<strong>
    <h6>Nombre de justifications : </strong><input type="number" id="txtJustif" name="justifications" id="number"></h6><br>
<button class="btn btn-success" type="submit">Valider</button>
<button class="btn btn-danger" type="reset">Réinitialiser</button>
