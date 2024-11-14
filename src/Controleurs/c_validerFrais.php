<?php

/**
 * Gestion de l'accueil
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
 */

use Outils\Utilitaires;
include PATH_FONCTIONS . 'mesFonctions.php';
$mois = Utilitaires::getMois(date('d/m/Y'));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
isset($_SESSION['idVisiteurAValider']) ? $idVisiteurAValider = $_SESSION['idVisiteurAValider']:$_SESSION['idVisiteurAValider']="";
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteurAValider, $mois);

switch ($action) {
    case 'selectionnerVisiteur':
	include PATH_VIEWS . 'v_listeVisiteur.php';
        break;
    case 'selectionnerMois':
        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        break;
    case 'voirEtatFrais':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteurAValider, $leMois);
        $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        include PATH_VIEWS . 'v_validationFiche.php';
        break;
    case 'validerMajFraisForfait':
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (Utilitaires::lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($idVisiteurAValider, $mois, $lesFrais);
        } else {
            Utilitaires::ajouterErreur('Les valeurs des frais doivent être numériques');
            include PATH_VIEWS . 'v_erreurs.php';
        }
        include PATH_VIEWS . 'v_listeVisiteur.php';
        include PATH_VIEWS . 'v_validerMois.php';
        include PATH_VIEWS . 'v_validationFiche.php';
        break;
    case 'supprimerFrais':
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->supprimerFraisHorsForfait($idFrais);
        break;
}


