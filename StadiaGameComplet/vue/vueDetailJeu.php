<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=accueil">Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=jeux">Jeux</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=categorie&id=<?= $leJeu['category_id'] ?>"><?= htmlspecialchars($laCategorie['name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($leJeu['title']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Image du jeu -->
        <div class="col-md-5">
            <div class="card mb-4">
                <?php if (!empty($leJeu['image'])): ?>
                    <img src="<?= htmlspecialchars($leJeu['image']) ?>" class="card-img-top img-fluid" alt="<?= htmlspecialchars($leJeu['title']) ?>">
                <?php else: ?>
                    <div class="text-center p-5 bg-light">
                        <i class="fas fa-gamepad fa-5x text-muted"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title">Détails techniques</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Date de sortie:</span>
                            <span><?= date('d/m/Y', strtotime($leJeu['release_date'])) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Développeur:</span>
                            <span><?= htmlspecialchars($leJeu['developer']) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Éditeur:</span>
                            <span><?= htmlspecialchars($leJeu['publisher']) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Plateforme:</span>
                            <span><?= htmlspecialchars($leJeu['platform']) ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Informations du jeu -->
        <div class="col-md-7">
            <h1><?= htmlspecialchars($leJeu['title']) ?></h1>
            
            <div class="mb-3">
                <?php
                // Afficher les étoiles de notation
                $rating = $leJeu['rating'] ?? 0;
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        echo '<i class="fas fa-star text-warning"></i>';
                    } elseif ($i - 0.5 <= $rating) {
                        echo '<i class="fas fa-star-half-alt text-warning"></i>';
                    } else {
                        echo '<i class="far fa-star text-warning"></i>';
                    }
                }
                ?>
                <span class="ms-2">(<?= $leJeu['rating'] ?>/5)</span>
            </div>
            
            <div class="mb-4">
                <h3 class="text-primary"><?= number_format($leJeu['price'], 2, ',', ' ') ?> €</h3>
                <p class="<?= $leJeu['stock'] > 0 ? 'text-success' : 'text-danger' ?>">
                    <?php if ($leJeu['stock'] > 0): ?>
                        <i class="fas fa-check-circle"></i> En stock (<?= $leJeu['stock'] ?> disponibles)
                    <?php else: ?>
                        <i class="fas fa-times-circle"></i> Rupture de stock
                    <?php endif; ?>
                </p>
            </div>
            
            <?php if ($leJeu['stock'] > 0): ?>
                <form action="index.php" method="GET" class="mb-4">
                    <input type="hidden" name="action" value="ajoutPanier">
                    <input type="hidden" name="id" value="<?= $leJeu['id'] ?>">
                    <div class="input-group mb-3">
                        <input type="number" name="quantite" class="form-control" value="1" min="1" max="<?= $leJeu['stock'] ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> Ajouter au panier
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary mb-4" disabled>
                    <i class="fas fa-shopping-cart"></i> Indisponible
                </button>
            <?php endif; ?>
            
            <ul class="nav nav-tabs" id="gameTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="requirements-tab" data-bs-toggle="tab" data-bs-target="#requirements" type="button" role="tab" aria-controls="requirements" aria-selected="false">Configuration requise</button>
                </li>
            </ul>
            
            <div class="tab-content p-3 border border-top-0 mb-4" id="gameTabsContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                    <p><?= nl2br(htmlspecialchars($leJeu['description'])) ?></p>
                </div>
                <div class="tab-pane fade" id="requirements" role="tabpanel" aria-labelledby="requirements-tab">
                    <h5>Configuration minimale</h5>
                    <p><?= nl2br(htmlspecialchars($leJeu['min_requirements'] ?? 'Information non disponible')) ?></p>
                    
                    <h5>Configuration recommandée</h5>
                    <p><?= nl2br(htmlspecialchars($leJeu['rec_requirements'] ?? 'Information non disponible')) ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jeux similaires -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Jeux similaires</h3>
            
            <div class="row">
                <?php
                // Filtrer pour exclure le jeu actuel et limiter à 4 jeux
                $count = 0;
                foreach ($jeuxSimilaires as $jeuSimilaire):
                    if ($jeuSimilaire['id'] != $leJeu['id'] && $count < 4):
                        $count++;
                ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($jeuSimilaire['image'])): ?>
                                <img src="<?= htmlspecialchars($jeuSimilaire['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($jeuSimilaire['title']) ?>">
                            <?php else: ?>
                                <div class="text-center p-3 bg-light">
                                    <i class="fas fa-gamepad fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($jeuSimilaire['title']) ?></h5>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0"><?= number_format($jeuSimilaire['price'], 2, ',', ' ') ?> €</span>
                                        <a href="index.php?action=detail&id=<?= $jeuSimilaire['id'] ?>" class="btn btn-sm btn-primary">Voir détails</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>