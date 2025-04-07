<?php
include_once "bd.inc.php";

/**
 * Récupère tous les jeux
 * @return array Liste des jeux
 */
function getAllJeux() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM games ORDER BY title");
        $req->execute();
        
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Récupère les jeux par catégorie
 * @param int $categoryId ID de la catégorie
 * @return array Liste des jeux de cette catégorie
 */
function getJeuxByCategorie($categoryId) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM games WHERE category_id = :categoryId ORDER BY title");
        $req->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $req->execute();
        
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Récupère un jeu par son ID
 * @param int $id ID du jeu
 * @return array|bool Informations du jeu ou false si non trouvé
 */
function getJeuById($id) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM games WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


function searchJeux($title) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from games where title like :title");
        $req->bindValue(':title', "%" . $title . "%", PDO::PARAM_STR);

        $req->execute();

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}





/**
 * Récupère toutes les catégories
 * @return array Liste des catégories
 */
function getAllCategories() {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM categories ORDER BY name");
        $req->execute();
        
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Récupère les jeux récemment ajoutés
 * @param int $limit Nombre de jeux à récupérer
 * @return array Liste des jeux récents
 */
function getNewJeux($limit = 6) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM games ORDER BY release_date DESC LIMIT :limit");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Récupère les jeux populaires (basés sur les ventes)
 * @param int $limit Nombre de jeux à récupérer
 * @return array Liste des jeux populaires
 */
function getPopularJeux($limit = 6) {
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("
            SELECT g.*, COUNT(oi.id) as sales 
            FROM games g
            LEFT JOIN order_items oi ON g.id = oi.game_id
            LEFT JOIN orders o ON oi.order_id = o.id
            GROUP BY g.id
            ORDER BY sales DESC
            LIMIT :limit
        ");
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        $req->execute();
        
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

/**
 * Récupère une catégorie par son ID
 * @param int $id ID de la catégorie
 * @return array|bool Informations de la catégorie ou false si non trouvée
 */
function getCategorieById($id) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM categories WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
        return $resultat;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}