<?php
/**
 * Contrôleur pour l'inscription
 */
include_once "modele/utilisateur.dao.php";

// Variables pour la vue
$erreurs = [];
$nomUtilisateur = "";
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
    $nomUtilisateur = isset($_POST['username']) ? trim($_POST['username']) : "";
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $motDePasse = isset($_POST['password']) ? $_POST['password'] : "";
    $motDePasseConfirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : "";
    
    // Valider les données
    if (empty($nomUtilisateur)) {
        $erreurs[] = "Le nom d'utilisateur est requis.";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    
    if (empty($motDePasse)) {
        $erreurs[] = "Le mot de passe est requis.";
    } elseif (strlen($motDePasse) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    
    if ($motDePasse !== $motDePasseConfirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }
    
    // Si pas d'erreurs, créer l'utilisateur
    if (empty($erreurs)) {
        $success = inscrireUtilisateur($nomUtilisateur, $email, $motDePasse);
        
        if ($success) {
            // Rediriger vers la page de connexion avec un message de succès
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "Inscription réussie. Vous pouvez maintenant vous connecter."
            ];
            header("Location: index.php?action=connexion");
            exit();
        } else {
            $erreurs[] = "Cette adresse email est déjà utilisée.";
        }
    }
}

// Récupérer toutes les catégories pour le menu
include_once "modele/jeu.dao.php";
$lesCategories = getAllCategories();

// Inclure la vue
include "vue/entete.php";
include "vue/vueInscription.php";
include "vue/pied.php";
?>