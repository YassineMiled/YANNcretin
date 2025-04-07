<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=accueil">Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=jeux">Jeux</a></li>
            <li class="breadcrumb-item active" aria-current="page">Recherche: <?= htmlspecialchars($title) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar avec les filtres -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Catégories</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach ($lesCategories as $categorie): ?>
                            <li class="list-group-item">
                                <a href="index.php?action=categorie&id=<?= $categorie['id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($categorie['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Rechercher</h5>
                </div>
                <div class="card-body">
                    <form action="index.php" method="GET">
                        <input type="hidden" name="action" value="recherche">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control" placeholder="Nom du jeu..." value="<?= htmlspecialchars($keyword) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Liste des jeux -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Résultats de recherche pour "<?= htmlspecialchars($title) ?>"</h1>
                <span class="badge bg-primary"><?= count($lesJeux) ?> jeux trouvés</span>
            </div>
            
            <div class="row">
                <?php if (empty($lesJeux)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            Aucun jeu ne correspond à votre recherche.
                            <a href="index.php?action=jeux" class="btn btn-primary ms-3">Voir tous les jeux</a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($lesJeux as $jeu): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($jeu['image'])): ?>
                                    <img src="<?= htmlspecialchars($jeu['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($jeu['title']) ?>">
                                <?php else: ?>
                                    <div class="text-center p-3 bg-light">
                                        <i class="fas fa-gamepad fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <?php
                                        // Afficher le titre 
                                        $title = htmlspecialchars($jeu['title']);
                                        echo $title;
                                        ?>
                                    </h5>


                                    <p class="card-text text-muted">
                                        <?php
                                        // Afficher la description
                                        $description = substr(htmlspecialchars($jeu['description']), 0, 100) . ' ...';
                                        echo $description;
                                        ?>
                                    </p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0"><?= number_format($jeu['price'], 2, ',', ' ') ?> €</span>
                                            <a href="index.php?action=detail&id=<?= $jeu['id'] ?>" class="btn btn-sm btn-primary">Voir détails</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>Date de sortie: <?= date('d/m/Y', strtotime($jeu['release_date'])) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>