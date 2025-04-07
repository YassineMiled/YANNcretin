<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Erreur</h3>
                </div>
                <div class="card-body">
                    <p class="lead"><?= htmlspecialchars($erreur) ?></p>
                    <div class="text-center mt-4">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left"></i> Retour à la page précédente
                        </a>
                        <a href="index.php?action=accueil" class="btn btn-primary">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>