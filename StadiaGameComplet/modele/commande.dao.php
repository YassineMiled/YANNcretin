<?php
include_once "bd.inc.php";
include "panier.dao.php";

/**
 * Crée une commande à partir du panier
 * @param int $userId ID de l'utilisateur
 * @return int|bool ID de la commande ou false si échec
 */
function creerCommande($userId) {
    // Vérifier si le panier n'est pas vide
    $contenu = getContenuPanier();
    if (empty($contenu)) {
        error_log("Panier vide pour l'utilisateur: " . $userId);
        return false;
    }
    
    // Vérifier si l'ID utilisateur est valide
    if (empty($userId) || !is_numeric($userId)) {
        error_log("ID utilisateur invalide: " . $userId);
        return false;
    }
    
    // Calculer le montant total
    $total = getTotalPanier();
    
    error_log("Tentative de création de commande - UserID: " . $userId . ", Total: " . $total);
    
    try {
        $cnx = connexionPDO();
        
        // Commencer une transaction
        $cnx->beginTransaction();
        
        // Insérer la commande dans la table orders
        $req = $cnx->prepare("
            INSERT INTO orders (
                user_id, total_amount, status, order_date
            ) VALUES (
                :user_id, :total_amount, 'en attente', NOW()
            )
        ");
        
        $req->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $req->bindValue(':total_amount', $total, PDO::PARAM_STR);
        $result = $req->execute();
        
        if (!$result) {
            error_log("Échec de l'insertion dans orders: " . implode(", ", $req->errorInfo()));
            throw new PDOException("Échec de l'insertion dans orders");
        }
        
        // Récupérer l'ID de la commande
        $commandeId = $cnx->lastInsertId();
        error_log("Commande créée avec ID: " . $commandeId);
        
        if (!$commandeId) {
            error_log("Impossible d'obtenir l'ID de la commande");
            throw new PDOException("Impossible d'obtenir l'ID de la commande");
        }
        
        // Ajouter les articles de la commande
        foreach ($contenu as $article) {
            $req = $cnx->prepare("
                INSERT INTO order_items (
                    order_id, game_id, quantity, price
                ) VALUES (
                    :order_id, :game_id, :quantity, :price
                )
            ");
            
            $req->bindValue(':order_id', $commandeId, PDO::PARAM_INT);
            $req->bindValue(':game_id', $article['jeu']['id'], PDO::PARAM_INT);
            $req->bindValue(':quantity', $article['quantite'], PDO::PARAM_INT);
            $req->bindValue(':price', $article['jeu']['price'], PDO::PARAM_STR);
            $result = $req->execute();
            
            if (!$result) {
                error_log("Échec de l'insertion dans order_items: " . implode(", ", $req->errorInfo()));
                throw new PDOException("Échec de l'insertion dans order_items");
            }
            
            // Mettre à jour le stock
            $req = $cnx->prepare("
                UPDATE games 
                SET stock = stock - :quantity 
                WHERE id = :game_id
            ");
            
            $req->bindValue(':quantity', $article['quantite'], PDO::PARAM_INT);
            $req->bindValue(':game_id', $article['jeu']['id'], PDO::PARAM_INT);
            
            $result = $req->execute();
            
            if (!$result) {
                error_log("Échec de la mise à jour du stock: " . implode(", ", $req->errorInfo()));
                throw new PDOException("Échec de la mise à jour du stock");
            }
        }
        
        // Valider la transaction
        $cnx->commit();
        error_log("Transaction validée avec succès");
        
        // Vider le panier
        viderPanier();
        
        return $commandeId;
    } catch (PDOException $e) {
        // En cas d'erreur, annuler la transaction
        error_log("Erreur lors de la création de la commande: " . $e->getMessage());
        
        if (isset($cnx) && $cnx->beginTransaction()) {
            $cnx->rollBack();
            error_log("Transaction annulée");
        }
        return false;
    }
}

/**
 * Récupère les détails d'une commande ou toutes les commandes d'un utilisateur
 * @param int $userId ID de l'utilisateur
 * @param int|null $commandeId ID de la commande (optionnel)
 * @return array|bool Détail(s) de la commande ou false si non autorisé
 */
function getCommandePassee($userId, $commandeId = null) {
    try {
        $cnx = connexionPDO();
        
        // Si un ID de commande est fourni, récupérer cette commande spécifique
        if ($commandeId !== null) {
            $req = $cnx->prepare("SELECT * FROM orders WHERE id = :id AND user_id = :userId");
            $req->bindParam(':id', $commandeId, PDO::PARAM_INT);
            $req->bindParam(':userId', $userId, PDO::PARAM_INT);
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        } else {
            // Sinon, récupérer toutes les commandes de l'utilisateur
            $req = $cnx->prepare("SELECT * FROM orders WHERE user_id = :userId ORDER BY order_date DESC");
            $req->bindParam(':userId', $userId, PDO::PARAM_INT);
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }  
}

/**
 * Récupère les articles d'une commande spécifique
 * @param int $commandeId ID de la commande
 * @return array Liste des articles de la commande
 */
function getArticlesCommande($commandeId) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            SELECT oi.*, g.title, g.image 
            FROM order_items oi
            JOIN games g ON oi.game_id = g.id
            WHERE oi.order_id = :commandeId
        ");
        $req->bindParam(':commandeId', $commandeId, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}