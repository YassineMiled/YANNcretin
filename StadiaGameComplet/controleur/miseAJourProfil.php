<?php
include_once "modele/utilisateur.dao.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    $_SESSION['flash'] = [
        'type' => 'info',
        'message' => "Vous devez être connecté pour accéder à votre profil."
    ];
    header("Location: index.php?action=connexion");
    exit();
}

// Variables pour la vue
$erreurs = [];
$success = false;

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = isset($_POST['username']) ? trim($_POST['username']) : "";
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    
    // Valider les données
    if (empty($username)) {
        $erreurs[] = "Le nom d'utilisateur est requis.";
    }
    
    if (empty($email)) {
        $erreurs[] = "L'adresse email est requise.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    
    // Si pas d'erreurs, mettre à jour le profil
    if (empty($erreurs)) {
        $data = [
            'username' => $username,
            'email' => $email
        ];
        
        $success = updateUser($_SESSION['user']['id'], $data);
        
        if ($success) {
            // Mettre à jour les données de session
            $updateUser = getUtilisateurParId($_SESSION['user']['id']);
            $_SESSION['user'] = $updateUser;
            
            // Message de succès
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => "Votre profil a été mis à jour avec succès."
            ];
        } else {
            $erreurs[] = "Une erreur s'est produite lors de la mise à jour du profil.";
        }
    }
    
    // Si des erreurs, les mettre en session
    if (!empty($erreurs)) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => $erreurs[0]
        ];
    }
}

// Rediriger vers le profil
header("Location: index.php?action=profil");
exit();
?>