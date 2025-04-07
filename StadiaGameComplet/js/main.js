/**
 * StadiaGame - JavaScript principal
 * Ce fichier contient les scripts pour l'interactivité du site
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialisation des popovers Bootstrap
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Fermeture automatique des alertes après 5 secondes
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 10000);
    
    // Gestion des boutons de quantité dans le panier
    setupQuantityButtons();
    
    // Animation au défilement
    setupScrollAnimations();
    
    // Validation des formulaires
    setupFormValidation();
    
    // Recherche en direct
    setupLiveSearch();
});

/**
 * Configure les boutons d'incrémentation/décrémentation de quantité
 */
function setupQuantityButtons() {
    // Boutons d'augmentation de quantité
    var incrementButtons = document.querySelectorAll('.btn-increment');
    incrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.parentNode.querySelector('input[type="number"]');
            var max = parseInt(input.getAttribute('max'));
            var currentValue = parseInt(input.value);
            
            if (currentValue < max) {
                input.value = currentValue + 1;
                // Déclencher l'événement change pour mettre à jour les totaux
                var event = new Event('change');
                input.dispatchEvent(event);
            }
        });
    });
    
    // Boutons de diminution de quantité
    var decrementButtons = document.querySelectorAll('.btn-decrement');
    decrementButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.parentNode.querySelector('input[type="number"]');
            var min = parseInt(input.getAttribute('min'));
            var currentValue = parseInt(input.value);
            
            if (currentValue > min) {
                input.value = currentValue - 1;
                // Déclencher l'événement change pour mettre à jour les totaux
                var event = new Event('change');
                input.dispatchEvent(event);
            }
        });
    });
    
    // Mise à jour des sous-totaux lors du changement de quantité
    var quantityInputs = document.querySelectorAll('.cart-quantity-input');
    quantityInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            updateCartSubtotals();
        });
    });
}

/**
 * Mise à jour des sous-totaux du panier
 */
function updateCartSubtotals() {
    var rows = document.querySelectorAll('.cart-item');
    var total = 0;
    
    rows.forEach(function(row) {
        var price = parseFloat(row.querySelector('.item-price').dataset.price);
        var quantity = parseInt(row.querySelector('.cart-quantity-input').value);
        var subtotal = price * quantity;
        
        row.querySelector('.item-subtotal').textContent = subtotal.toFixed(2) + ' €';
        total += subtotal;
    });
    
    document.querySelector('.cart-total').textContent = total.toFixed(2) + ' €';
}
/**
 * Configure les animations au défilement
 */
function setupScrollAnimations() {
    var animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    function checkIfInView() {
        animatedElements.forEach(function(element) {
            var rect = element.getBoundingClientRect();
            var windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight * 0.8) {
                element.classList.add('fade-in');
            }
        });
    }
    
    // Vérifier au chargement initial
    checkIfInView();
    
    // Vérifier lors du défilement
    window.addEventListener('scroll', checkIfInView);
}

/**
 * Configure la validation des formulaires
 */
function setupFormValidation() {
    var forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Validation spécifique pour le formulaire d'enregistrement
    var registerForm = document.getElementById('register-form');
    if (registerForm) {
        var password = registerForm.querySelector('#password');
        var passwordConfirm = registerForm.querySelector('#password_confirm');
        
        passwordConfirm.addEventListener('input', function() {
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
        
        password.addEventListener('input', function() {
            if (password.value !== passwordConfirm.value) {
                passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                passwordConfirm.setCustomValidity('');
            }
        });
    }
}

/**
 * Configure la recherche en direct
 */
function setupLiveSearch() {
    var searchInput = document.getElementById('live-search');
    
    if (searchInput) {
        var searchResultsContainer = document.getElementById('search-results');
        var searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            var query = this.value.trim();
            
            if (query.length >= 3) {
                searchTimeout = setTimeout(function() {
                    // Ici, nous simulons une recherche AJAX
                    // Dans une implémentation réelle, vous feriez une requête AJAX vers le serveur
                    
                    // Afficher un indicateur de chargement
                    searchResultsContainer.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Recherche en cours...</div>';
                    searchResultsContainer.style.display = 'block';
                    
                    // Simuler un délai de requête
                    setTimeout(function() {
                        // Pour cette démonstration, nous affichons simplement des résultats fictifs
                        searchResultsContainer.innerHTML = '<div class="list-group">' +
                            '<a href="/games/show?id=1" class="list-group-item list-group-item-action">Résultat de recherche 1</a>' +
                            '<a href="/games/show?id=2" class="list-group-item list-group-item-action">Résultat de recherche 2</a>' +
                            '<a href="/games/show?id=3" class="list-group-item list-group-item-action">Résultat de recherche 3</a>' +
                            '</div>';
                    }, 500);
                    
                }, 300);
            } else {
                searchResultsContainer.style.display = 'none';
            }
        });
        
        // Cacher les résultats de recherche lorsque l'utilisateur clique ailleurs
        document.addEventListener('click', function(event) {
            if (!searchInput.contains(event.target) && !searchResultsContainer.contains(event.target)) {
                searchResultsContainer.style.display = 'none';
            }
        });
    }
}

/**
 * Affiche une notification toast
 * @param {string} message - Message à afficher
 * @param {string} type - Type de notification (success, error, warning, info)
 */
function showToast(message, type = 'success') {
    var toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }
    
    var bgClass = 'bg-' + (type === 'error' ? 'danger' : type);
    var iconClass = type === 'success' ? 'fas fa-check-circle' :
                    type === 'error' ? 'fas fa-exclamation-circle' :
                    type === 'warning' ? 'fas fa-exclamation-triangle' :
                    'fas fa-info-circle';
    
    var toastHtml = `
        <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="${iconClass} me-2"></i> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    toastContainer.innerHTML += toastHtml;
    
    var toastElement = toastContainer.lastElementChild;
    var toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 5000 });
    toast.show();
    
    // Supprimer l'élément après la fermeture
    toastElement.addEventListener('hidden.bs.toast', function () {
        this.remove();
    });
}

/**
 * Ajoute un jeu au panier via AJAX
 * @param {number} gameId - ID du jeu
 * @param {number} quantity - Quantité à ajouter
 */
function addToCartAjax(gameId, quantity = 1) {
    // Dans un environnement réel, vous utiliseriez fetch ou XMLHttpRequest pour envoyer une requête au serveur
    // Pour cette démonstration, nous simulons simplement la réponse
    
    setTimeout(function() {
        // Simuler une réponse positive
        showToast('Le jeu a été ajouté à votre panier !', 'success');
        
        // Mettre à jour le compteur de panier
        var cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            var currentCount = parseInt(cartBadge.textContent || '0');
            cartBadge.textContent = currentCount + quantity;
            cartBadge.style.display = 'inline-block';
        }
    }, 500);
}