<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=accueil">Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=mesCommandes">Mes commandes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Commande #<?= $commandeDetail['id'] ?></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Détails de la commande #<?= $commandeDetail['id'] ?></h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Informations de commande</h5>
                            <p><strong>Numéro de commande:</strong> <?= $commandeDetail['id'] ?></p>
                            <p><strong>Date:</strong> <?= date('d/m/Y H:i', strtotime($commandeDetail['order_date'])) ?></p>
                            <p><strong>Statut:</strong> 
                                <span class="badge <?= $commandeDetail['status'] == 'en attente' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= $commandeDetail['status'] ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Récapitulatif</h5>
                            <p><strong>Total:</strong> <?= number_format($commandeDetail['total_amount'], 2, ',', ' ') ?> €</p>
                        </div>
                    </div>
                    
                    <h5 class="mb-3">Articles commandés</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articlesCommande as $article): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if (!empty($article['image'])): ?>
                                                <img src="<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="img-thumbnail me-3" style="width: 60px;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($article['title']) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($article['price'], 2, ',', ' ') ?> €</td>
                                    <td><?= $article['quantity'] ?></td>
                                    <td><?= number_format($article['price'] * $article['quantity'], 2, ',', ' ') ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong><?= number_format($commandeDetail['total_amount'], 2, ',', ' ') ?> €</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="index.php?action=mesCommandes" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour à mes commandes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>