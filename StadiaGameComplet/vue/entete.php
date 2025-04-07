<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StadiaGame - Votre boutique de jeux vidéo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php?action=accueil">
                    <img src="images/logo.png" alt="StadiaGame" width="40" height="40" class="d-inline-block align-text-top me-2">
                    StadiaGame
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=accueil">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=jeux">Jeux</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                if (isset($lesCategories)) {
                                    foreach ($lesCategories as $categorie) {
                                        echo '<li><a class="dropdown-item" href="index.php?action=categorie&id=' . $categorie['id'] . '">' . htmlspecialchars($categorie['name']) . '</a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=about">À propos</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <form class="d-flex me-2" action="index.php" method="GET">
                            <input type="hidden" name="action" value="recherche">
                            <input class="form-control me-2" type="search" name="keyword" placeholder="Rechercher..." aria-label="Search">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                        
                        <a href="index.php?action=panier" class="btn btn-outline-light position-relative me-2">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
                            // Récupérer le nombre d'articles dans le panier de l'utilisateur actuel
                            include_once "modele/panier.dao.php";
                            $nombreArticles = getNombreArticlesPanier();
                            if ($nombreArticles > 0):
                            ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $nombreArticles ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="index.php?action=profil">Mon profil</a></li>
                                    <li><a class="dropdown-item" href="index.php?action=mesCommandes">Mes commandes</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="index.php?action=deconnexion">Déconnexion</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="index.php?action=connexion" class="btn btn-outline-light">
                                <i class="fas fa-sign-in-alt"></i> Connexion
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main>