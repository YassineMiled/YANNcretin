<div class="container mt-4">
    <h1>Votre panier</h1>
    
    <?php if (empty($contenuPanier)): ?>
        <div class="alert alert-info mt-4">
            Votre panier est vide.
            <a href="index.php?action=jeux" class="btn btn-primary ms-3">Parcourir les jeux</a>
        </div>
    <?php else: ?>
        <div class="card my-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Articles dans votre panier</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contenuPanier as $article): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($article['jeu']['image'])): ?>
                                                <img src="<?= htmlspecialchars($article['jeu']['image']) ?>" alt="<?= htmlspecialchars($article['jeu']['title']) ?>" class="img-thumbnail me-3" style="width: 60px;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($article['jeu']['title']) ?></h6>
                                                <small class="text-muted">
                                                    <?php if ($article['jeu']['stock'] <= 5): ?>
                                                        <span class="text-danger">Plus que <?= $article['jeu']['stock'] ?> en stock !</span>
                                                    <?php else: ?>
                                                        En stock
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($article['jeu']['price'], 2, ',', ' ') ?> €</td>
                                    <td>
                                        <form action="index.php" method="GET" class="input-group" style="width: 120px;">
                                            <input type="hidden" name="action" value="ajoutPanier">
                                            <input type="hidden" name="id" value="<?= $article['jeu']['id'] ?>">
                                            <input type="number" name="quantite" value="<?= $article['quantite'] ?>" min="1" max="<?= $article['jeu']['stock'] ?>" class="form-control form-control-sm">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td><?= number_format($article['sousTotal'], 2, ',', ' ') ?> €</td>
                                    <td>
                                        <a href="index.php?action=supprimerPanier&id=<?= $article['jeu']['id'] ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td colspan="2"><strong><?= number_format($totalPanier, 2, ',', ' ') ?> €</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="index.php?action=jeux" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Continuer les achats
                </a>
                <div>
                    <a href="index.php?action=viderPanier" class="btn btn-outline-danger me-2">
                        <i class="fas fa-trash"></i> Vider le panier
                    </a>
                    <a href="index.php?action=commander" class="btn btn-success">
                        <i class="fas fa-check"></i> Passer commande
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($contenuPanier)): ?>
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Vous pourriez aussi aimer</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($jeuxRecommandes as $jeu): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($jeu['image'])): ?>
                                    <img src="<?= htmlspecialchars($jeu['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($jeu['title']) ?>">
                                <?php else: ?>
                                    <div class="text-center p-3 bg-light">
                                        <i class="fas fa-gamepad fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($jeu['title']) ?></h5>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 mb-0"><?= number_format($jeu['price'], 2, ',', ' ') ?> €</span>
                                            <a href="index.php?action=detail&id=<?= $jeu['id'] ?>" class="btn btn-sm btn-primary">Voir détails</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>