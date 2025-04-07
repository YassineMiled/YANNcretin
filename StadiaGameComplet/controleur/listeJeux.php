<?php
/**
 * Contrôleur pour la liste des jeux
 */
include_once "modele/jeu.dao.php";

// Récupérer tous les jeux
$lesJeux = getAllJeux();

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueListeJeux.php";
include "vue/pied.php";
?>