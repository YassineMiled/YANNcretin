<div class="container mt-4">
    <h1>Mes commandes</h1>
    
    <?php if (empty($lesCommandes)): ?>                    
        <div class="alert alert-info">
            Vous n'avez pas encore passé de commande.
        </div>
        <p>
            <a href="index.php?action=jeux" class="btn btn-primary">Parcourir le catalogue</a>
        </p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Commande #</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lesCommandes as $commande): ?>
                        <tr>
                            <td><?= $commande['id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($commande['order_date'])) ?></td>
                            <td><?= number_format($commande['total_amount'], 2, ',', ' ') ?> €</td>
                            <td>
                                <span class="badge <?= $commande['status'] == 'en attente' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= $commande['status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="index.php?action=mesCommandes&id=<?= $commande['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Voir détails
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>