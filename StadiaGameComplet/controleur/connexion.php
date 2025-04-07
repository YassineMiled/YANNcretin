<?php
/**
 * Contrôleur pour la connexion
 */
include_once "modele/utilisateur.dao.php";

// Variables pour la vue
$erreurs = [];
$email = "";

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user'])) {
    // Rediriger vers la page d'accueil
    header("Location: index.php?action=accueil");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $motDePasse = isset($_POST['password']) ? $_POST['password'] : "";
    
    // Valider les données
    if (empty($email)) {
        $erreurs[] = "L'adresse email est requise.";
    }
    
    if (empty($motDePasse)) {
        $erreurs[] = "Le mot de passe est requis.";
    }
    
    // Si pas d'erreurs, vérifier les identifiants
    if (empty($erreurs)) {
        $utilisateur = verifierUtilisateur($email, $motDePasse);
        
        if ($utilisateur) {
            // Connexion réussie
            $_SESSION['user'] = $utilisateur;
            
            // Rediriger vers la page d'accueil
            header("Location: index.php?action=accueil");
            exit();
        } else {
            $erreurs[] = "Email ou mot de passe incorrect.";
        }
    }
}

// Récupérer toutes les catégories pour le menu
include_once "modele/jeu.dao.php";
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueConnexion.php";
include "vue/pied.php";
?>