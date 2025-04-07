<?php
/**
 * Contrôleur pour la page À propos
 */
include_once "modele/jeu.dao.php";

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueAbout.php";
include "vue/pied.php";
?>