<?php
/**
 * Contrôleur pour ajouter un jeu au panier
 */
include_once "modele/panier.dao.php";

// Vérifier si l'ID et la quantité sont fournis
if (!isset($_GET["id"])) {
    // Rediriger vers la liste des jeux si pas d'ID
    header("Location: index.php?action=jeux");
    exit();
}

// Récupérer l'ID du jeu et la quantité
$id = intval($_GET["id"]);
$quantite = isset($_GET["quantite"]) ? intval($_GET["quantite"]) : 1;

// Ajouter le jeu au panier
$success = ajouterAuPanier($id, $quantite);

if ($success) {
    // Message de succès
    $_SESSION['flash'] = [
        'type' => 'success',
        'message' => "Le jeu a été ajouté à votre panier."
    ];
} else {
    // Message d'erreur
    $_SESSION['flash'] = [
        'type' => 'danger',
        'message' => "Une erreur s'est produite lors de l'ajout au panier."
    ];
}

// Rediriger vers le panier
header("Location: index.php?action=panier");
exit();
?>