<?php
include_once "bd.inc.php";
include_once "jeu.dao.php";

/**
 * Initialise le panier dans la session si nécessaire
 * @param int|null $userId ID de l'utilisateur connecté
 */
function initPanier($userId = null) {
    // Utiliser l'ID de l'utilisateur comme clé pour stocker son panier
    $panierKey = $userId ? "panier_" . $userId : "panier_guest";
    
    if (!isset($_SESSION[$panierKey])) {
        $_SESSION[$panierKey] = [];
    }
    
    return $panierKey;
}

/**
 * Récupère la clé du panier pour l'utilisateur actuel
 * @return string Clé du panier dans la session
 */
function getPanierKey() {
    $userId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
    return initPanier($userId);
}

/**
 * Ajoute un jeu au panier
 * @param int $jeuId ID du jeu
 * @param int $quantite Quantité à ajouter
 * @return bool Succès ou échec de l'opération
 */
function ajouterAuPanier($jeuId, $quantite = 1) {
    // Récupérer la clé du panier
    $panierKey = getPanierKey();
    
    // Valider la quantité
    $quantite = max(1, intval($quantite));
    
    // Vérifier si le jeu existe
    $jeu = getJeuById($jeuId);
    if (!$jeu) {
        return false;
    }
    
    // Vérifier le stock
    if ($jeu['stock'] < $quantite) {
        return false;
    }
    
    // Ajouter ou mettre à jour l'article dans le panier
    if (isset($_SESSION[$panierKey][$jeuId])) {
        $_SESSION[$panierKey][$jeuId] += $quantite;
    } else {
        $_SESSION[$panierKey][$jeuId] = $quantite;
    }
    
    return true;
}


function mettreAJourQuantitePanier($jeuId, $quantite) {
    // Récupérer la clé du panier
    $panierKey = getPanierKey();
    
    // Valider la quantité
    $quantite = max(0, intval($quantite));
    
    if (!isset($_SESSION[$panierKey][$jeuId])) {
        return false;
    }
    
    // Vérifier si le jeu existe
    $jeu = getJeuById($jeuId);
    if (!$jeu) {
        return false;
    }
    
    // Vérifier le stock
    if ($jeu['stock'] < $quantite) {
        return false;
    }
    
    // Si la quantité est 0, supprimer l'article du panier
    if ($quantite == 0) {
        return supprimerDuPanier($jeuId);
    }
    
    // Mettre à jour la quantité
    $_SESSION[$panierKey][$jeuId] = $quantite;
    
    return true;
}


function supprimerDuPanier($jeuId) {
    // Récupérer la clé du panier
    $panierKey = getPanierKey();
    
    // Vérifier si le jeu existe dans le panier
    if (!isset($_SESSION[$panierKey][$jeuId])) {
        return false;
    }
    
    // Supprimer l'article du panier
    unset($_SESSION[$panierKey][$jeuId]);
    
    return true;
}


function viderPanier() {
    $panierKey = getPanierKey();
    $_SESSION[$panierKey] = [];
}

/**
 * Obtient le contenu du panier avec les détails des jeux
 * @return array Contenu du panier avec détails
 */
function getContenuPanier() {
    // Récupérer la clé du panier
    $panierKey = getPanierKey();
    
    $contenu = [];
    
    // Si le panier est vide, retourner un tableau vide
    if (empty($_SESSION[$panierKey])) {
        return $contenu;
    }
    
    // Récupérer les détails de chaque jeu dans le panier
    foreach ($_SESSION[$panierKey] as $jeuId => $quantite) {
        $jeu = getJeuById($jeuId);
        
        // Si le jeu existe, l'ajouter à la liste des articles
        if ($jeu) {
            $contenu[] = [
                'jeu' => $jeu,
                'quantite' => $quantite,
                'sousTotal' => $jeu['price'] * $quantite
            ];
        }
    }
    
    return $contenu;
}


function getTotalPanier() {
    $contenu = getContenuPanier();
    $total = 0; 
    foreach ($contenu as $article) {
        $total += $article['sousTotal'];
    }  
    return $total;
}


function getNombreArticlesPanier() {
    // Récupérer la clé du panier
    $panierKey = getPanierKey();
    
    $nombre = 0;
    
    if (isset($_SESSION[$panierKey])) {
        foreach ($_SESSION[$panierKey] as $quantite) {
            $nombre += $quantite;
        }
    }
    
    return $nombre;
}