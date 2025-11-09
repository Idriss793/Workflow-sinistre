@extends('templates.navbar3')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Carte principale -->
            <div class="card shadow-lg border-0">
                <!-- En-tête de la carte -->
                <div class="card-header py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h2 class="h4 mb-1">
                                <i class="fas fa-user-plus me-2"></i>Nouvel Utilisateur
                            </h2>
                            <p class="mb-0 opacity-75">Ajouter un nouveau membre au personnel</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Informations personnelles -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-id-card me-2"></i>Informations Personnelles
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">
                                        Nom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               placeholder="Entrez le nom" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="first_name" class="form-label fw-semibold">
                                        Prénom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               placeholder="Entrez le prénom" required>
                                    </div>
                                    @error('first_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-address-book me-2"></i>Informations de Contact
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-1"></i>Numéro de téléphone <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">+241</span>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                               placeholder="066 77 09 10" required>
                                    </div>
                                    @error('phone_number')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-1"></i>Adresse Email <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-at text-muted"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="exemple@entreprise.fr" required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Rôle et sécurité -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-shield-alt me-2"></i>Rôle et Sécurité
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label fw-semibold">
                                        <i class="fas fa-user-tag me-1"></i>Rôle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" name="role" id="role" required>
                                        <option value="">Choisir un rôle...</option>
                                        <option value="gestionnaire">
                                            <i class="fas fa-cogs me-2"></i>Gestionnaire
                                        </option>
                                        <option value="expert">
                                            <i class="fas fa-chart-line me-2"></i>Expert
                                        </option>
                                        <option value="comptable">
                                            <i class="fas fa-calculator me-2"></i>Comptable
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock me-1"></i>Mot de passe <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-key text-muted"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               value="Admin123" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Mot de passe par défaut : <code>Admin123</code>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                            <a href="#" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>Enregistrer l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="mt-4 text-center">
                <p class="text-muted small">
                    <i class="fas fa-lightbulb me-1"></i>
                    L'utilisateur recevra un email avec ses identifiants de connexion
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });

    // Animation au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.card');
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
</script>

<style>
    .card {
        border: none;
        border-radius: 1rem;
    }
    
    .card-header {
        border-radius: 1rem 1rem 0 0 !important;
        border-bottom: none;
    }
    
    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #eb440cff;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    
    .input-group-text {
        border: 1px solid #e0e0e0;
        border-right: none;
        background-color: #f8f9fa;
    }
    
    .form-control:focus + .input-group-text {
        border-color: #0d6efd;
    }
    
    .btn {
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }
    
    h5 {
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
</style>
@endsection