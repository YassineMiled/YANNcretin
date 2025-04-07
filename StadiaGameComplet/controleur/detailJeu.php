<?php
/**
 * Contrôleur pour le détail d'un jeu
 */
include_once "modele/jeu.dao.php";

// Récupérer l'ID du jeu
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    // Rediriger vers la liste des jeux si aucun ID n'est fourni
    header("Location: index.php?action=jeux");
    exit();
}

// Récupérer les détails du jeu
$leJeu = getJeuById($id);

// Vérifier si le jeu existe
if (!$leJeu) {
    // Jeu non trouvé, afficher une erreur
    $erreur = "Le jeu demandé n'existe pas.";
    include "vue/entete.php";
    include "vue/vueErreur.php";
    include "vue/pied.php";
    exit();
}

// Récupérer la catégorie du jeu
$laCategorie = getCategorieById($leJeu['category_id']);

// Récupérer des jeux similaires (de la même catégorie)
$jeuxSimilaires = getJeuxByCategorie($leJeu['category_id']);

// Inclure la vue
include "vue/entete.php";
include "vue/vueDetailJeu.php";
include "vue/pied.php";
?>