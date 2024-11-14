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

include PATH_FONCTIONS . 'mesFonctions.php';
$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

isset($_SESSION['idVisiteurAValider']) ? $idVisiteurAValider = $_SESSION['idVisiteurAValider'] : $_SESSION['idVisiteurAValider'] = "";
isset($_SESSION['moisChoisi']) ? $moisChoisi = $_SESSION['moisChoisi'] : $_SESSION['moisChoisi'] = $mois;

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurAValider, $moisChoisi);

switch ($action) {
    case 'selectionnerVisiteur':
        include PATH_VIEWS . 'v_listeVisiteur.php';
        break;

    case 'selectionnerMois':
        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        break;

    case 'voirEtatFrais':
        $moisChoisi = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? $_SESSION['moisChoisi'];
        $_SESSION['moisChoisi'] = $moisChoisi;

        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurAValider, $moisChoisi);
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];

        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        include PATH_VIEWS . 'v_validationFiche.php';
        break;

    case 'validerMajFraisForfait':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (Utilitaires::lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteurAValider, $moisChoisi, $lesFrais);
        } else {
            Utilitaires::ajouterErreur('Les valeurs des frais doivent être numériques');
            include PATH_VIEWS . 'v_erreurs.php';
        }
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();

    case 'validerMajFraisHorsForfait':
        $lesFraisHorsForfait = filter_input(INPUT_POST, 'frais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        $erreurs = [];
        foreach ($lesFraisHorsForfait as $idFrais => $frais) {
            $date = $frais['date'];
            $libelle = $frais['libelle'];
            $montant = $frais['montant'];

            if (!is_numeric($montant)) {
                $erreurs[] = "Le montant du frais avec ID $idFrais doit être numérique.";
            }
            if (empty($date) || empty($libelle)) {
                $erreurs[] = "La date et le libellé sont obligatoires pour le frais avec ID $idFrais.";
            }
        }
        if (count($erreurs) > 0) {
            foreach ($erreurs as $erreur) {
                Utilitaires::ajouterErreur($erreur);
            }
            include PATH_VIEWS . 'v_erreurs.php';
        } else {
            foreach ($lesFraisHorsForfait as $idFrais => $frais) {
                $date = $frais['date'];
                $libelle = $frais['libelle'];
                $montant = $frais['montant'];
                $pdo->majFraisHorsForfait($idVisiteurAValider, $moisChoisi, $idFrais, $date, $libelle, $montant);
            }
            header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
            exit();
        }


    case 'supprimerFrais':
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->supprimerFraisHorsForfait($idFrais);
        header('Location: index.php?uc=validerFrais&action=voirEtatFrais');
        exit();
}
