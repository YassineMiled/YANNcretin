<?php
/**
 * Contrôleur pour supprimer un article du panier
 */
include_once "modele/panier.dao.php";

// Vérifier si l'ID est fourni
if (!isset($_GET["id"])) {
    // Rediriger vers le panier si pas d'ID
    header("Location: index.php?action=panier");
    exit();
}

// Récupérer l'ID du jeu
$id = intval($_GET["id"]);

// Supprimer l'article du panier
$success = supprimerDuPanier($id);

if ($success) {
    // Message de succès
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => "L'article a été supprimé de votre panier."
    ];
} else {
    // Message d'erreur
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => "Une erreur s'est produite lors de la suppression."
    ];
}

// Rediriger vers le panier
header("Location: index.php?action=panier");
exit();
?>