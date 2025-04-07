<?php
/**
 * Contrôleur pour la recherche de jeux
 */
include_once "modele/jeu.dao.php";

// Récupérer le mot-clé de recherche
if (isset($_GET["keyword"])) {
    $title = $_GET["keyword"];
} else {
    $title = "";
}

// Récupérer les jeux correspondant au mot-clé
$lesJeux = searchJeux($title);

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueRechercheJeux.php";
include "vue/pied.php";
?>