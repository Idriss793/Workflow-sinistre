@extends('templates.navbar1')

@section('content')
<style>
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .img-hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .expert-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
    }

    .status-card {
        border-left: 4px solid #007bff;
    }

    .action-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
    }

    .action-card .card-body {
        padding: 1.5rem;
    }

    .document-status-icon {
        font-size: 1.2rem;
    }

    .photo-gallery img {
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .expertise-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .upload-area:hover {
        border-color: #0d6efd;
        background-color: #f0f7ff;
    }

    .upload-area.dragover {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        transform: scale(1.01);
    }

    .upload-content {
        pointer-events: none;
    }

    #browseButton {
        pointer-events: auto;
    }

    .file-preview-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 6px;
        margin-top: 0.5rem;
    }

    .file-icon {
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .file-info {
        flex-grow: 1;
    }

    .file-name {
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .file-size {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .remove-file {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 4px;
    }

    .remove-file:hover {
        background-color: #f8d7da;
    }
</style>

<div class="container-fluid my-4">
    
    <!-- En-tête Expert -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div>
                <h2 class="mb-1">Expertise du sinistre #{{ $sinistres->numero_sinistre ?? 'N/A' }}</h2>
                <small class="text-muted">Mission d'expertise automobile</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="expert-badge">
                <i class="fas fa-user-tie me-2"></i>Expert Auto
            </span>
            <span class="badge bg-warning fs-6">{{ $sinistres->statut->lib_statut ?? 'Statut inconnu' }}</span>
        </div>
    </div>

    <!-- Section Actions Rapides Expert -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card status-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar-alt text-primary me-2"></i>Date du sinistre</h6>
                            <p class="mb-0">{{ $sinistres->created_at ? \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y') : 'Date inconnue' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-map-marker-alt text-primary me-2"></i>Lieu</h6>
                            <p class="mb-0">{{ $sinistres->lieu ?? 'Lieu non spécifié' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets  -->
    <ul class="nav nav-tabs" id="expertTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">
                <i class="fas fa-info-circle me-2"></i>Détails du sinistre
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="parties-tab" data-bs-toggle="tab" data-bs-target="#parties" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Parties impliquées
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="photos-tab" data-bs-toggle="tab" data-bs-target="#photos" type="button" role="tab">
                <i class="fas fa-camera me-2"></i>Photos & Preuves
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-expert-tab" data-bs-toggle="tab" data-bs-target="#documents-expert" type="button" role="tab">
                <i class="fas fa-folder-open me-2"></i>Documents
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="expertise-tab" data-bs-toggle="tab" data-bs-target="#expertise" type="button" role="tab">
                <i class="fas fa-tools me-2"></i>Mon Expertise
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content py-4" id="expertTabsContent">

        <!-- Infos Sinistre  -->
        @include('expert.partials.informations')
        <!--  Partie impliqué  -->
        @include('expert.partials.partie_implique')
         <!--  Photos et preuve  -->
        @include('expert.partials.photos')
         <!-- Documents  -->
        @include('expert.partials.documents')
         <!-- Expertise -->
        @include('expert.partials.expertise')
      
    </div>
</div>

<!-- Modal pour agrandir les images -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo du sinistre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" alt="Photo agrandie">
            </div>
        </div>
    </div>
</div>

<!-- Modal rapport d'expertise -->
<div class="modal fade" id="rapportModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Rapport d'expertise rapide
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Actions rapides</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success">
                                <i class="fas fa-thumbs-up me-2"></i>Accepter le sinistre
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="fas fa-clock me-2"></i>Demander docs supplémentaires
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Rejeter le sinistre
                            </button>
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <h6>Notes rapides</h6>
                        <textarea class="form-control" rows="6" placeholder="Vos observations..."></textarea>
                        <button class="btn btn-primary mt-2 w-100">
                            <i class="fas fa-save me-2"></i>Sauvegarder les notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal image
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function(e) {
            const trigger = e.relatedTarget;
            const imageSrc = trigger.getAttribute('data-src');
            modalImage.src = imageSrc;
        });
    }

    
});
</script>
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion active des liens de navigation
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Animation du compteur de notifications
            const notificationCount = document.getElementById('notificationCount');
            if (notificationCount && parseInt(notificationCount.textContent) > 0) {
                notificationCount.style.display = 'flex';
            }

            // Smooth scroll pour les ancres
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection