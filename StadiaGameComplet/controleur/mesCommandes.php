<?php
/**
 * Contrôleur pour la gestion des commandes
 */
include_once "modele/commande.dao.php";
include_once "modele/jeu.dao.php";

// Récupérer l'ID de l'utilisateur connecté
$userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

// Vérifier que l'utilisateur est connecté
if ($userId === null) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    $_SESSION['flash'] = [
        'type' => 'info',
        'message' => "Vous devez être connecté pour accéder à vos commandes."
    ];
    header("Location: index.php?action=connexion");
    exit;
}

// On vérifie si un ID de commande est spécifié dans l'URL
$commandeId = isset($_GET['id']) ? intval($_GET['id']) : null;

// Récupérer les données de commande
if ($commandeId !== null) {
    // Récupérer les détails d'une commande spécifique
    $commandeDetail = getCommandePassee($userId, $commandeId);
    
    // Si la commande n'appartient pas à l'utilisateur ou n'existe pas
    if (!$commandeDetail) {
        // Rediriger vers la liste des commandes
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => "Cette commande n'existe pas ou ne vous appartient pas."
        ];
        header("Location: index.php?action=mesCommandes");
        exit;
    }
    
    // Récupérer les articles de cette commande
    $articlesCommande = getArticlesCommande($commandeId);
    
    // Inclure la vue pour afficher les détails de la commande
    include "vue/entete.php";
    include "vue/vueDetailCommande.php";
    include "vue/pied.php";
} else {
    // Récupérer toutes les commandes de l'utilisateur
    $lesCommandes = getCommandePassee($userId);
    
    // Récupérer toutes les catégories pour le menu
    $lesCategories = getAllCategories();
    
    // Inclure la vue pour afficher la liste des commandes
    include "vue/entete.php";
    include "vue/vuemesCommandes.php";
    include "vue/pied.php";
}