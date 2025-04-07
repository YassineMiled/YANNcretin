<?php
/**
 * Contrôleur pour la page d'accueil
 */
include_once "modele/jeu.dao.php";

// Récupérer les jeux récents
$lesJeuxRecents = getNewJeux(6);

// Récupérer les jeux populaires
$lesJeuxPopulaires = getPopularJeux(6);
// $lesJeux = getAllJeux();
// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueAccueil.php";
include "vue/pied.php";
?>