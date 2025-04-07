<!-- Hero Section -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
       
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="" class="d-block w-100" alt="StadiaGame - Jeux PC">
            <div class="carousel-caption d-none d-md-block">
                <h2>Bienvenue sur StadiaGame</h2>
                <p>Découvrez notre vaste collection de jeux vidéo</p>
                <a href="index.php?action=jeux" class="btn btn-primary">Voir tous les jeux</a>
            </div>
        </div>
        <div class="carousel-item">
           
            <div class="carousel-caption d-none d-md-block">
                <h2>Les dernières nouveautés</h2>
                <p>Restez à jour avec les jeux les plus récents</p>
                <a href="index.php?action=nouveautes" class="btn btn-primary">Voir les nouveautés</a>
            </div>
        </div>
        <div class="carousel-item">

            <div class="carousel-caption d-none d-md-block">
                <h2>Offres spéciales</h2>
                <p>Profitez de nos remises exclusives</p>
                <a href="index.php?action=promotions" class="btn btn-primary">Voir les promotions</a>
            </div>
        </div>
    </div>

</div>

<div class="container mt-5">
    <!-- Featured Categories -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Parcourir par catégorie</h2>
        <div class="row g-4">
            <?php 
            // Afficher jusqu'à 3 catégories sur la page d'accueil
            $compteur = 0;
            foreach ($lesCategories as $categorie) {
                if ($compteur >= 3) break;
                $compteur++;
            ?>
                <div class="col-md-4">
                    <div class="card category-card h-100">
                        <?php if (!empty($categorie['image'])): ?>
                            <img src="<?= htmlspecialchars($categorie['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($categorie['name']) ?>">
                        <?php else: ?>
                            <div class="text-center p-4 bg-light">
                                <i class="fas fa-gamepad fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($categorie['name']) ?></h5>
                            <a href="index.php?action=categorie&id=<?= $categorie['id'] ?>" class="btn btn-outline-primary stretched-link">Explorer</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    
    <!-- New Releases -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Nouveautés</h2>
            <a href="index.php?action=jeux" class="btn btn-outline-primary">Voir tout</a>
        </div>
        <div class="row">
            <?php foreach ($lesJeuxRecents as $jeu): ?>
                <div class="col-md-2 col-sm-6 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($jeu['image'])): ?>
                            <img src="<?= htmlspecialchars($jeu['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($jeu['title']) ?>">
                        <?php else: ?>
                            <div class="text-center p-2 bg-light">
                                <i class="fas fa-gamepad fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($jeu['title']) ?></h5>
                            <div class="mt-auto">
                                <p class="card-text fw-bold"><?= number_format($jeu['price'], 2, ',', ' ') ?> €</p>
                                <a href="index.php?action=detail&id=<?= $jeu['id'] ?>" class="btn btn-primary btn-sm stretched-link">Voir détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    
    <section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Jeux populaires</h2>
        <a href="index.php?action=jeux" class="btn btn-outline-primary">Voir tout</a>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-4">
        <?php foreach ($lesJeuxPopulaires as $jeu): ?>
            <div class="col">
                <div class="card h-100">
                    <?php if (!empty($jeu['image'])): ?>
                        <img src="<?= htmlspecialchars($jeu['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($jeu['title']) ?>">
                    <?php else: ?>
                        <div class="text-center p-2 bg-light">
                            <i class="fas fa-gamepad fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($jeu['title']) ?></h5>
                    </div>
                    <div class="mt-auto">
                        <p class="card-text fw-bold"><?= number_format($jeu['price'], 2, ',', ' ') ?> €</p>
                        <a href="index.php?action=detail&id=<?= $jeu['id'] ?>" class="btn btn-primary btn-sm stretched-link">Voir détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
    
    <!-- Features -->
    <section class="mb-5">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="feature-box p-4 rounded">
                    <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                    <h4>Livraison rapide</h4>
                    <p class="text-muted">Livraison en 24h pour toutes vos commandes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box p-4 rounded">
                    <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                    <h4>Paiement sécurisé</h4>
                    <p class="text-muted">Vos transactions sont 100% sécurisées</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box p-4 rounded">
                    <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                    <h4>Support 24/7</h4>
                    <p class="text-muted">Notre équipe est disponible 7j/7</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-box p-4 rounded">
                    <i class="fas fa-undo fa-3x mb-3 text-primary"></i>
                    <h4>Satisfait ou remboursé</h4>
                    <p class="text-muted">14 jours pour changer d'avis</p>
                </div>
            </div>
        </div>
    </section>
</div>