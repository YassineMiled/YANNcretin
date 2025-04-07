<?php
/**
 * Contrôleur pour afficher le panier
 */
include_once "modele/panier.dao.php";

// Récupérer le contenu du panier
$contenuPanier = getContenuPanier();
$totalPanier = getTotalPanier();

// Récupérer des jeux recommandés
include_once "modele/jeu.dao.php";
$jeuxRecommandes = getNewJeux(4);

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vuePanier.php";
include "vue/pied.php";
?>