<?php
/**
 * StadiaGame - Fichier d'entrée principal
 * Point d'entrée de l'application
 */

// Démarrer la session
session_start();

// Inclure le contrôleur principal
include_once "controleur/controleurPrincipal.php";

// Récupérer l'action à exécuter
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "defaut";
}

// Déterminer le fichier contrôleur à utiliser
$fichier = controleurPrincipal($action);

// Inclure le fichier contrôleur
include_once "controleur/$fichier";

?>