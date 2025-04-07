<?php
/**
 * Contrôleur pour la liste des jeux par catégorie
 */
include_once "modele/jeu.dao.php";

// Récupérer l'ID de la catégorie
if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    // Rediriger vers la liste des jeux si aucun ID n'est fourni
    header("Location: index.php?action=jeux");
    exit();
}

// Récupérer les détails de la catégorie
$laCategorie = getCategorieById($id);

// Vérifier si la catégorie existe
if (!$laCategorie) {
    // Catégorie non trouvée, afficher une erreur
    $erreur = "La catégorie demandée n'existe pas.";
    include "vue/entete.php";
    include "vue/vueErreur.php";
    include "vue/pied.php";
    exit();
}

// Récupérer les jeux de cette catégorie
$lesJeux = getJeuxByCategorie($id);

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueCategorieJeux.php";
include "vue/pied.php";
?>