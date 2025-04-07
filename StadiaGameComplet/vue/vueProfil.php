<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mon compte</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#profile-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                        <i class="fas fa-user me-2"></i> Informations personnelles
                    </a>
                    <a href="index.php?action=mesCommandes" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-bag me-2"></i> Mes commandes
                    </a>
                    <a href="index.php?action=deconnexion" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Informations personnelles -->
                <div class="tab-pane fade show active" id="profile-info">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informations personnelles</h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($success) && $success): ?>
                                <div class="alert alert-success">
                                    Vos informations ont été mises à jour avec succès.
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($erreurs)): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php foreach ($erreurs as $erreur): ?>
                                            <li><?= $erreur ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <form action="index.php?action=updProfil" method="POST">
                                <input type="hidden" name="action" value="updProfil">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="joined" class="form-label">Membre depuis</label>
                                    <input type="text" class="form-control" id="joined" value="<?= date('d/m/Y', strtotime($user['created_at'])) ?>" disabled>
                                </div>
                                <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>