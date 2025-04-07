<?php
/**
 * Contrôleur pour afficher le profil utilisateur
 */
include_once "modele/utilisateur.dao.php";
include_once "modele/jeu.dao.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    $_SESSION['flash'] = [
        'type' => 'info',
        'message' => "Vous devez être connecté pour accéder à votre profil."
    ];
    header("Location: index.php?action=connexion");
    exit();
}

// Récupérer les informations de l'utilisateur
$user = $_SESSION['user'];

// Récupérer les commandes de l'utilisateur si la fonction existe
$commandes = [];
if (function_exists('getCommandePassee')) {
    $commandes = getCommandePassee($user['id']);
}

// Variables pour la vue
$erreurs = [];
$success = false;

// Récupérer toutes les catégories pour le menu
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueProfil.php";
include "vue/pied.php";
?>