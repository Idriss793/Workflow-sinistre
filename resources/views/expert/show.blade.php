@extends('templates.navbar2')
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

    <!-- Onglets Bootstrap -->
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

        <!-- Détails du sinistre -->
        <div class="tab-pane fade show active" id="details" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Informations du sinistre</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong><i class="fas fa-hashtag text-muted me-2"></i>Numéro :</strong><br>
                            <span class="fs-5 text-primary">{{ $sinistres->numero_sinistre ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-tag text-muted me-2"></i>Type :</strong><br>
                            <span class="badge bg-secondary">{{ $sinistres->type_sinistre ?? 'Type inconnu' }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-traffic-light text-muted me-2"></i>Statut :</strong><br>
                            <span class="badge bg-primary">{{ $sinistres->statut->lib_statut ?? 'Statut inconnu' }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong><i class="fas fa-align-left text-muted me-2"></i>Description complète :</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            {{ $sinistres->description ?? 'Aucune description disponible' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parties impliquées -->
        <div class="tab-pane fade" id="parties" role="tabpanel">
            <div class="row g-4">
                
                <!-- Assuré principal -->
                <div class="col-lg-6">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Assuré principal</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($sinistres->assurePrincipals ?? [] as $assure)
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Nom</small><br>
                                        <strong>{{ $assure->nom ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Prénom</small><br>
                                        <strong>{{ $assure->prenom ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Téléphone</small><br>
                                        <a href="tel:{{ $assure->num_tel ?? '' }}" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-1"></i>{{ $assure->num_tel ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Police N°</small><br>
                                        <code>{{ $assure->num_pol ?? 'N/A' }}</code>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Matricule véhicule</small><br>
                                        <span class="badge bg-dark">{{ $assure->num_matri ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Aucun assuré principal trouvé</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Assuré tiers -->
                <div class="col-lg-6">
                    @forelse ($sinistres->assureTiers ?? [] as $assure_tiers)
                        <div class="card h-100 border-warning mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-user-alt me-2"></i>Partie adverse</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Nom</small><br>
                                        <strong>{{ $assure_tiers->nom_tiers ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Prénom</small><br>
                                        <strong>{{ $assure_tiers->prenom_tiers ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Téléphone</small><br>
                                        <a href="tel:{{ $assure_tiers->num_tel_tiers ?? '' }}" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-1"></i>{{ $assure_tiers->num_tel_tiers ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Police N°</small><br>
                                        <code>{{ $assure_tiers->num_pol_tiers ?? 'N/A' }}</code>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Matricule</small><br>
                                        <span class="badge bg-dark">{{ $assure_tiers->num_matri_tiers ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Compagnie d'assurance tiers</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>Compagnie :</strong> {{ $assure_tiers->nom_assurance_tiers ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Contact :</strong> {{ $assure_tiers->contact_assurance_tiers ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="card h-100 border-warning mb-3">
                            <div class="card-body text-center">
                                <p class="text-muted">Aucune partie adverse trouvée</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Photos & Preuves -->
        <div class="tab-pane fade" id="photos" role="tabpanel">
            <h5><i class="fas fa-camera text-primary me-2"></i>Galerie photos du sinistre</h5>
            <p class="text-muted mb-4">Cliquez sur une image pour l'agrandir</p>
            
            <div class="row photo-gallery">
                @forelse(($sinistres->documents ?? collect())->whereIn('type_doc', ['photos']) as $document)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{ asset('storage/' . $document->path) }}" 
                                 class="card-img-top img-hover-zoom"
                                 alt="Photo sinistre"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal"
                                 data-src="{{ asset('storage/' . $document->path) }}">
                            <div class="card-body p-2">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucune photo n'a été téléchargée pour ce sinistre.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Documents -->
        <div class="tab-pane fade" id="documents-expert" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <h5><i class="fas fa-clipboard-list text-primary me-2"></i>État des documents requis</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Photos des dégâts
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Constat amiable signé
                            <i class="fas fa-times-circle text-danger document-status-icon" title="Document manquant"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Copie de la carte grise
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Relevé d'informations permis
                            <i class="fas fa-times-circle text-danger document-status-icon" title="Document manquant"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Devis de réparation
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                    </ul>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-download text-primary me-2"></i>Documents téléversés</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Nom</th>
                                            <th>Taille</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sinistres->documents ?? [] as $document)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">{{ $document->type_doc ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $document->nom_fichier ?? 'N/A' }}</td>
                                            <td><small>{{ $document->taille ?? 'N/A' }}</small></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank"
                                                        class="btn btn-outline-info btn-sm" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $document->path) }}" download
                                                        class="btn btn-outline-success btn-sm" title="Télécharger">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Aucun document trouvé</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mon Expertise -->
        <div class="tab-pane fade" id="expertise" role="tabpanel">
            <div class="expertise-section">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <h5><i class="fas fa-tools text-primary me-2"></i>Rapport d'expertise automobile</h5>
                <p class="text-muted">Rédigez votre rapport d'expertise professionnel</p>
                
                <form method="POST" enctype="multipart/form-data" action="{{ route('expert.storeExpertise') }}" id="expertiseForm">
                    @csrf
                    {{-- CORRECTION : Supprimer la duplication du champ sinistre_id --}}
                    <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? '' }}">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">État général du véhicule</label>
                            <select class="form-select" name="etat_general">
                                <option value="">Sélectionner...</option>
                                <option value="excellent">Excellent</option>
                                <option value="bon">Bon</option>
                                <option value="moyen">Moyen</option>
                                <option value="mauvais">Mauvais</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estimation des dégâts</label>
                            <div class="input-group">
                                <input type="number" name="estimation_degats" class="form-control" placeholder="0.00" step="0.01" required>
                                <span class="input-group-text">FCFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Analyse des dommages</label>
                        <textarea class="form-control" rows="4" name="analyse_dommages"
                        placeholder="Décrivez précisément l'étendue des dégâts, les pièces affectées, la nature des impacts..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Recommandations</label>
                        <textarea class="form-control" rows="3" name="recommandations"
                        placeholder="Vos recommandations professionnelles (réparation, remplacement, véhicule économiquement irréparable...)"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                               
                                <input class="form-check-input" type="checkbox" name="reparable" id="reparable" value="1">
                                <label class="form-check-label" for="reparable">
                                    Véhicule réparable
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                    
                                    <input class="form-check-input" type="checkbox" name="expertise_complementaire" id="reparable" value="1">
                                    <label class="form-check-label" for="expertise_complementaire">
                                    Expertise complémentaire requise
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Zone d'upload améliorée -->
                    <div class="upload-area mb-3 p-3 border rounded text-center" onclick="document.getElementById('documentUpload').click();" style="cursor: pointer;">
                        <i class="fas fa-upload fa-2x text-primary"></i>
                        <p class="mt-2">Ajouter un document</p>
                        <input type="file" class="d-none" id="documentUpload" name="expertise_path">
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"> {{-- CORRECTION : type="submit" --}}
                            <i class="fas fa-paper-plane me-2"></i>Envoyer le rapport
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

@endsection