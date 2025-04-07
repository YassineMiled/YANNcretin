<div class="container mt-4">
    <h1>Confirmation de commande</h1>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?= $_SESSION['flash']['type'] ?> mt-4">
            <?= $_SESSION['flash']['message'] ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <?php if (isset($commandeId) && $commandeId): ?>
        <div class="card my-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Commande confirmée</h5>
            </div>
            <div class="card-body">
                <h5>Merci pour votre commande!</h5>
                <p>Votre commande a été enregistrée avec succès. Voici un récapitulatif de votre commande :</p>
                
                <div class="table-responsive mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
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
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= number_format($article['jeu']['price'], 2, ',', ' ') ?> €</td>
                                    <td><?= $article['quantite'] ?></td>
                                    <td><?= number_format($article['sousTotal'], 2, ',', ' ') ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong><?= number_format($totalPanier, 2, ',', ' ') ?> €</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="alert alert-info mt-4">
                    <p>Un email de confirmation a été envoyé à votre adresse email.</p>
                    <p>Vous pouvez suivre l'état de votre commande dans la section "Mes commandes" de votre compte.</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php?action=jeux" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Continuer mes achats
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger mt-4">
            <p>Une erreur est survenue lors de la création de votre commande.</p>
            <p>Veuillez réessayer ou contacter notre service client.</p>
        </div>
        <div class="mt-4">
            <a href="index.php?action=panier" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour au panier
            </a>
        </div>
    <?php endif; ?>
</div>