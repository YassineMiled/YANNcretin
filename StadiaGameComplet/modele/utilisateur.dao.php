<?php
include_once "bd.inc.php";


function verifierUtilisateur($email, $motDePasse) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM users WHERE email = :email");
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();
        
        $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
        
        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if ($utilisateur && password_verify($motDePasse, $utilisateur['password'])) {
            // Ne pas renvoyer le mot de passe
            unset($utilisateur['password']);
            return $utilisateur;
        }
        
        return false;
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}



//@param string $motDePasse Mot de passe (en clair, sera hashé)
function inscrireUtilisateur($nomUtilisateur, $email, $motDePasse) {
    try {
        // Vérifier si l'email existe déjà
        if (getUtilisateurParEmail($email)) {
            return false;
        }
        
        $cnx = connexionPDO();
        $req = $cnx->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (:username, :email, :password, 'user', NOW())");
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
        $req->bindValue(':username', $nomUtilisateur, PDO::PARAM_STR);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->bindValue(':password', $motDePasseHash, PDO::PARAM_STR);
        
        return $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


function getUtilisateurParId($id) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT id, username, email, role, created_at FROM users WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getUtilisateurParEmail($email) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT id, username, email, role, created_at FROM users WHERE email = :email");
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();
        
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


//$data = nouvelles données
 function updateUser($id, $data) {
    try {
        
        if (isset($data['email'])) {
            $utilisateurExistant = getUtilisateurParEmail($data['email']);
            if ($utilisateurExistant && $utilisateurExistant['id'] != $id) {
                return false;
            }
        }
        
        $cnx = connexionPDO();
        
        // Construire la requête SQL de façon dynamique
        $sql = "UPDATE users SET ";
        $params = [];
        
        foreach ($data as $champ => $valeur) {
            $sql .= "$champ = :$champ, ";
            $params[":$champ"] = $valeur;
        }
        
        // ($sql, ", ") = supprime les espaces à la fin des champs
        $sql = rtrim($sql, ", ") . " WHERE id = :id";
        $params[":id"] = $id;
        
        // Préparer et exécuter la requête
        $req = $cnx->prepare($sql);
        
        return $req->execute($params);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}