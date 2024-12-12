<?php

/**
 * Gestion de l'accueil
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * ...
 */
use Outils\Utilitaires;

$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$idVisiteurAValider = $_SESSION['idVisiteurAValider'];

switch ($action) {
    case 'selectionnerVisiteur':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        include PATH_VIEWS . 'v_listeVisiteur.php';
        break;

    case 'selectionnerMois':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $idVisiteurAValider = filter_input(INPUT_POST, 'idVisiteurAValider', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $_SESSION['idVisiteurAValider'] = $idVisiteurAValider;
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteurAValider);
        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        break;

    case 'voirEtatFrais':
        $lesVisiteurs = $pdo->getLesVisiteurs();
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteurAValider);
        $moisASelectionner = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurAValider, $moisASelectionner);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurAValider, $moisASelectionner);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurAValider, $moisASelectionner);
        if($lesInfosFicheFrais != false){
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = Utilitaires::dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
            $_SESSION['moisASelectionner'] = $moisASelectionner;
        }
        else{
            echo ('aucune fiche de frais enregistrée pour ce mois-ci.');
        }

        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        include PATH_VIEWS . 'v_validationFiche.php';
        break;

    case 'validerMajFraisForfait':
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $moisASelectionner = $_SESSION['moisASelectionner'];
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);

        $pdo->majFraisForfait($idVisiteurAValider, $moisASelectionner, $lesFrais);
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();

    case 'validerMajFraisHorsForfait':
        $lesFraisHorsForfait = filter_input(INPUT_POST, 'frais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $moisASelectionner = $_SESSION['moisASelectionner'];
        foreach ($lesFraisHorsForfait as $idFrais => $frais) {
            $date = $frais['date'];
            $libelle = $frais['libelle'];
            $montant = $frais['montant'];
            $pdo->majFraisHorsForfait($idVisiteurAValider, $moisASelectionner, $idFrais, $date, $libelle, $montant);
        }
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();

    case 'refuserFrais':
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->refuserFraisHorsForfait($idVisiteurAValider, $idFrais);
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();
        
    case 'reporterFrais':
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->reporterFraisHorsForfait($idVisiteurAValider, $idFrais);
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();

    case 'validerFiche':
        $idVisiteurAValider = $_SESSION['idVisiteurAValider'];
        $moisASelectionner = $_SESSION['moisASelectionner'];
        $etat = 'VA';
        $montantValide = $pdo->calculerMontantValide($idVisiteurAValider, $moisASelectionner);
        $pdo->validerFicheFrais($idVisiteurAValider, $moisASelectionner, $etat, $montantValide);
        echo '<script>
        if (confirm("La fiche de frais a bien été validée avec un montant total de ' . $montantValide . ' €.")) {
            window.location.href = "index.php";
        } 
        </script>';
        exit();
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteurAValider, $moisASelectionner);
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurAValider, $moisASelectionner);
}