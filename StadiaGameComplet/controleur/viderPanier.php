<?php
/**
 * Contrôleur pour vider le panier
 */
include_once "modele/panier.dao.php";

// Vider le panier
viderPanier();

// Message de succès
$_SESSION['flash'] = [
    'type' => 'success',
    'message' => "Votre panier a été vidé."
];

// Rediriger vers le panier
header("Location: index.php?action=panier");
exit();
?>