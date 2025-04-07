<?php
/**
 * Contrôleur pour la déconnexion
 */

// Détruire la session
session_destroy();

// Rediriger vers la page d'accueil
header("Location: index.php?action=accueil");
exit();
?>