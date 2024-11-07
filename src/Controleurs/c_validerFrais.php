<?php
include PATH_FONCTIONS . 'mesFonctions.php';
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//isset($_SESSION['idVisiteur'])? $idVisiteur = $_SESSION['idVisiteur']: ;
$idVisiteur = $_SESSION['idVisiteur'];
isset($_SESSION['idVisiteurAValider']) ? $idVisiteurAValider = $_SESSION['idVisiteurAValider']:$_SESSION['idVisiteurAValider']="";

switch ($action) {
    case 'ValiderVisiteur':
        include PATH_VIEWS . 'v_ValiderVisiteur.php';
        break;
    case 'ValiderMois':
        include PATH_VIEWS . 'v_ValiderVisiteur.php';
        include PATH_VIEWS . 'v_ValiderMois.php';
        break;
    case 'ValiderFrais':
        include PATH_VIEWS . 'v_ValiderVisiteur.php';
        include PATH_VIEWS . 'v_ValiderMois.php';
        include PATH_VIEWS . 'v_ValiderFrais.php';
        break;
}


