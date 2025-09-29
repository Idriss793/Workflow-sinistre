@extends('layouts.app')
@section('content')
<style>
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        cursor: pointer;
    }

    .img-hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .card-clean {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .card-clean:hover {
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.12);
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .nav-tabs .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
        color: #495057;
    }

    .status-badge {
        font-size: 0.85rem;
        padding: 6px 12px;
        border-radius: 20px;
    }

    .document-progress {
        height: 8px;
        border-radius: 4px;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .table-clean th {
        border: none;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        margin-right: 15px;
    }

    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .upload-area:hover {
        border-color: #667eea;
        background: #f8f9ff;
    }

    .upload-area.dragover {
        border-color: #667eea;
        background: #f0f2ff;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .action-btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
</style>

<div class="container-fluid my-4">
    <!-- En-tête amélioré -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">    
                <div>
                    <h2 class="mb-1">Sinistre #{{$sinistres->numero_sinistre}}</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar me-1"></i>
                        Créé le {{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y')}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <span class="status-badge bg-warning text-dark fs-6">
                <i class="fas fa-clock me-1"></i>
                {{ $sinistres->statut->lib_statut}}
            </span>
            <!-- <div class="mt-2">
                <button class="btn btn-outline-primary btn-sm action-btn me-2">
                    <i class="fas fa-print me-1"></i> Imprimer
                </button>
                <button class="btn btn-primary btn-sm action-btn">
                    <i class="fas fa-share me-1"></i> Partager
                </button>
            </div> -->
        </div>
    </div>

    <!-- Alert documents manquants amélioré -->
    @if($manquants->isNotEmpty())
    <div class="alert alert-danger d-flex align-items-start mb-4" style="border-radius: 12px; border: none;">
        <div class="feature-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-grow-1">
            <h5 class="alert-heading mb-2">Documents manquants requis</h5>
            <p class="mb-2">Les documents suivants sont nécessaires pour finaliser le traitement :</p>
            <div class="row">
                @foreach($manquants as $doc)
                    @if(array_key_exists($doc, $nomsDocuments))
                    <div class="col-md-4 mb-1">
                        <i class="fas fa-times-circle text-danger me-2"></i>
                        {{ $nomsDocuments[$doc] }}
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Documents</h6>
                        <h3 class="mb-0 mt-2">{{ $sinistres->documents->count() }}</h3>
                    </div>
                    <i class="fas fa-file-alt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Photos</h6>
                            <h4 class="mb-0 mt-2 text-primary">{{ $sinistres->documents->where('type_doc', 'photos')->count() }}</h4>
                        </div>
                        <i class="fas fa-camera text-primary fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Assurés</h6>
                            <h4 class="mb-0 mt-2 text-success">{{ $sinistres->assurePrincipals->count() + $sinistres->assureTiers->count() }}</h4>
                        </div>
                        <i class="fas fa-users text-success fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-clean h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Dernière MAJ</h6>
                            <h6 class="mb-0 mt-2 text-info">{{ $sinistres->updated_at->diffForHumans() }}</h6>
                        </div>
                        <i class="fas fa-sync text-info fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Onglets Bootstrap améliorés -->
    <ul class="nav nav-tabs mb-4" id="sinistreTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                <i class="fas fa-info-circle me-2"></i>Informations
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-principal-tab" data-bs-toggle="tab" data-bs-target="#assure-principal" type="button" role="tab">
                <i class="fas fa-user me-2"></i>Assuré principal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-tiers-tab" data-bs-toggle="tab" data-bs-target="#assure-tiers" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Assuré(s) tiers
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                <i class="fas fa-folder me-2"></i>Documents
                @if($manquants->isNotEmpty())
                <span class="badge bg-danger ms-1">{{ $manquants->count() }}</span>
                @endif
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="devis-tab" data-bs-toggle="tab" data-bs-target="#devis" type="button" role="tab">
                <i class="fas fa-file-invoice-dollar me-2"></i>Devis
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="expertise-tab" data-bs-toggle="tab" data-bs-target="#expertise" type="button" role="tab">
                <i class="fas fa-tools me-2"></i>Expertise reçue
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="sinistreTabsContent">

        <!-- Infos Sinistre  -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-clean mb-4">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Détails du sinistre</h5>
                            <span class="badge bg-primary status-badge">{{ $sinistres->type_sinistre }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Date du sinistre</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <strong>{{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y à H:i') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Lieu du sinistre</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <strong>{{ $sinistres->lieu }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Description</label>
                                <div class="border rounded p-3 bg-light">
                                    {{ $sinistres->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Galerie photos  -->
            <div class="card card-clean">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galerie photos</h5>
                </div>
                <div class="card-body">
                    @if($sinistres->documents->where('type_doc', 'photos')->count() > 0)
                    <div class="row g-3">
                        @foreach($sinistres->documents->whereIn('type_doc', ['photos']) as $document)
                            @php
                                $imgPath = ($document->path && file_exists(storage_path('app/public/' . $document->path)))
                                            ? asset('storage/' . $document->path)
                                            : asset('image/defaultimage.png');
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-0">
                                    <img src="{{ $imgPath }}" class="card-img-top img-hover-zoom" alt="Photo du sinistre" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center p-2">
                                        <small class="text-muted">{{ $document->nom_fichier }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-camera"></i>
                        <h6>Aucune photo disponible</h6>
                        <p class="text-muted">Aucune photo n'a été uploadée pour ce sinistre.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assuré principal  -->
        <div class="tab-pane fade" id="assure-principal" role="tabpanel">
            @foreach ($sinistres->assurePrincipals as $assure)
            <div class="card card-clean">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Assuré principal</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Nom complet</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <strong>{{ $assure->prenom }} {{ $assure->nom }}</strong>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Téléphone</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone text-success me-2"></i>
                                    <strong>{{ $assure->num_tel }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Numéro de police</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-contract text-info me-2"></i>
                                    <strong>{{ $assure->num_pol }}</strong>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Matricule véhicule</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-car text-warning me-2"></i>
                                    <strong>{{ $assure->num_matri }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Assuré tiers  -->
        <div class="tab-pane fade" id="assure-tiers" role="tabpanel">
            <div class="row g-4">
                @foreach ($sinistres->assureTiers as $assure_tiers)
                <div class="col-lg-6">
                    <div class="card card-clean h-100">
                        <div class="card-header bg-transparent text-center">
                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Assuré tiers</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Nom complet</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-primary me-2"></i>
                                    <strong>{{ $assure_tiers->prenom_tiers }} {{ $assure_tiers->nom_tiers }}</strong>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Téléphone</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-mobile-alt text-success me-2"></i>
                                    <strong>{{ $assure_tiers->num_tel_tiers }}</strong>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Numéro de police</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-signature text-info me-2"></i>
                                    <strong>{{ $assure_tiers->num_pol_tiers }}</strong>
                                </div>
                            </div>
                            <div class="info-item">
                                <label class="form-label text-muted small mb-1">Matricule véhicule</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-car-side text-warning me-2"></i>
                                    <strong>{{ $assure_tiers->num_matri_tiers }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-clean h-100">
                        <div class="card-header bg-transparent text-center">
                            <h6 class="mb-0"><i class="fas fa-building me-2"></i>Compagnie d'assurance</h6>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Nom de la compagnie</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-landmark text-primary me-2"></i>
                                    <strong>{{ $assure_tiers->nom_assurance_tiers }}</strong>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text-muted small mb-1">Contact</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-address-book text-success me-2"></i>
                                    <strong>{{ $assure_tiers->contact_assurance_tiers }}</strong>
                                </div>
                            </div>
                            <div class="info-item">
                                <label class="form-label text-muted small mb-1">Localisation</label>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-pin text-danger me-2"></i>
                                    <strong>{{ $assure_tiers->contact_assurance_tiers }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Documents  -->
        <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row">
                <div class="col-lg-8">
                    <!-- État des documents  -->
                    <div class="card card-clean mb-4">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>État des documents</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @php
                                    $documentTypes = [
                                        'photos' => ['icon' => 'fa-camera', 'color' => 'success'],
                                        'constat' => ['icon' => 'fa-handshake', 'color' => 'danger'],
                                        'carte_grise' => ['icon' => 'fa-id-card', 'color' => 'success'],
                                        'permis' => ['icon' => 'fa-id-badge', 'color' => 'danger'],
                                        'devis' => ['icon' => 'fa-file-invoice', 'color' => 'success']
                                    ];
                                @endphp
                                
                                @foreach($documentTypes as $type => $info)
                                    @php
                                        $exists = $sinistres->documents->where('type_doc', $type)->count() > 0;
                                        $statusColor = $exists ? 'success' : 'danger';
                                        $statusIcon = $exists ? 'fa-check-circle' : 'fa-times-circle';
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="feature-icon" style="width: 40px; height: 40px; background: var(--bs-{{ $info['color'] }});">
                                                <i class="fas {{ $info['icon'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{ $nomsDocuments[$type] ?? ucfirst($type) }}</h6>
                                                <span class="badge bg-{{ $statusColor }} status-badge">
                                                    <i class="fas {{ $statusIcon }} me-1"></i>
                                                    {{ $exists ? 'Complété' : 'Manquant' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Liste des documents  -->
                    <div class="card card-clean">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Documents téléversés</h5>
                            <span class="badge bg-primary status-badge">{{ $sinistres->documents->count() }} fichier(s)</span>
                        </div>
                        <div class="card-body">
                            @if ($sinistres->documents && $sinistres->documents->count())
                            <div class="table-responsive">
                                <table class="table table-hover table-clean">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Nom du fichier</th>
                                            <th>Taille</th>
                                            <th>Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sinistres->documents as $document)
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <i class="fas fa-{{ $documentTypes[$document->type_doc]['icon'] ?? 'file' }} me-1"></i>
                                                    {{ $document->type_doc }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas
                                                        @if(str_contains($document->nom_fichier, '.pdf')) fa-file-pdf text-danger
                                                        @elseif(str_contains($document->nom_fichier, '.doc')) fa-file-word text-primary
                                                        @elseif(str_contains($document->nom_fichier, '.xls')) fa-file-excel text-success
                                                        @elseif(str_contains($document->nom_fichier, '.jpg') || str_contains($document->nom_fichier, '.png')) fa-file-image text-warning
                                                        @else fa-file text-secondary
                                                        @endif me-2">
                                                    </i>
                                                    {{ $document->nom_fichier }}
                                                </div>
                                            </td>
                                            <td>{{ $document->taille }}</td>
                                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $document->path) }}" download class="btn btn-outline-success">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <h6>Aucun document disponible</h6>
                                <p class="text-muted">Aucun document n'a été uploadé pour ce sinistre.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Formulaire d'upload  -->
                    <div class="card card-clean">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Ajouter un document</h5>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <form method="POST" enctype="multipart/form-data" action="{{ route('document.store') }}" id="uploadForm">
                                @csrf
                                <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? old('sinistre_id') }}">
                                
                                <div class="upload-area mb-3 p-3 border rounded text-center" onclick="document.getElementById('documentUpload').click();" style="cursor: pointer;">
                                    <i class="fas fa-upload fa-2x text-primary"></i>
                                    <p class="mt-2">Ajouter un document</p>
                                    <input type="file" class="d-none" id="documentUpload" name="path">
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Type de document</label>
                                    <select class="form-select" id="" name="type_doc" required>
                                        <option value="" disabled selected>Sélectionner un type...</option>
                                        <option value="constat">Constat amiable</option>
                                        <option value="photos">Photos</option>
                                        <option value="permis">Relevé permis</option>
                                        <option value="carte_grise">Carte grise</option>
                                        <option value="devis">Devis</option>
                                        <option value="contrat">Contrat Assuré</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Nom du document</label>
                                    <input type="text" class="form-control" id="" name="nom_fichier" placeholder="Ex: Constat amiable signé">
                                </div>

                                <button type="submit" class="btn btn-primary w-100 action-btn">
                                    <i class="fas fa-upload me-2"></i>Uploader le document
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Devis  -->
        <div class="tab-pane fade" id="devis" role="tabpanel">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card card-clean">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Liste des devis</h5>
                            <span class="badge bg-primary status-badge">1 devis</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-clean">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                                                    <span>Réparation véhicule</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">200 000 FCFA</span>
                                            </td>
                                            <td>28/09/2025</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-clean">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Nouveau devis</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="sinistre_id" value="{{ $sinistres->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control" placeholder="Ex: Réparation carrosserie avant" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Montant</label>
                                    <div class="input-group">
                                        <input type="number" name="montant" class="form-control" placeholder="0.00" step="0.01" required>
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 action-btn">
                                    <i class="fas fa-save me-2"></i>Enregistrer le devis
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Expertise -->

        <!-- Expertise -->
 
<div class="tab-pane fade" id="expertise" role="tabpanel">
    <div class="expertise-section">
      
        @if($sinistres->expertise->isEmpty())
            <!-- État vide amélioré -->
            <div class="card card-clean">
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune expertise disponible</h5>
                        <p class="text-muted mb-4">Aucun rapport d'expertise n'a été soumis pour ce sinistre.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-sync me-1"></i>Actualiser
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Demander une expertise
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            

            <!-- Liste des expertises sous forme de cartes détaillées -->
            <div class="row g-4">
                @foreach($sinistres->expertise as $index => $exp)
                <div class="col-12">
                    <div class="card card-clean expertise-card">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon" style="width: 45px; height: 45px;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Rapport d'expertise #{{ $index + 1 }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $exp->created_at->translatedFormat('d F Y à H:i') }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                @if($exp->expertise_path)
                                <a href="{{ asset('storage/'.$exp->expertise_path) }}" 
                                   class="btn btn-outline-primary btn-sm" 
                                   target="_blank"
                                   data-bs-toggle="tooltip" 
                                   title="Voir le document">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/'.$exp->expertise_path) }}" 
                                   download
                                   class="btn btn-outline-success btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- État général et estimation -->
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">État général</small>
                                        <span class="badge 
                                            @if($exp->etat_general == 'excellent') bg-success
                                            @elseif($exp->etat_general == 'bon') bg-info
                                            @elseif($exp->etat_general == 'moyen') bg-warning
                                            @elseif($exp->etat_general == 'mauvais') bg-danger
                                            @else bg-secondary
                                            @endif status-badge">
                                            {{ $exp->etat_general ?? 'Non spécifié' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Estimation des dégâts</small>
                                        <h5 class="text-primary mb-0">
                                            {{ number_format($exp->estimation_degats ?? 0, 0, ',', ' ') }} FCFA
                                        </h5>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Véhicule réparable</small>
                                        @if($exp->reparable)
                                            <span class="badge bg-success status-badge">
                                                <i class="fas fa-check me-1"></i>Réparable
                                            </span>
                                        @else
                                            <span class="badge bg-danger status-badge">
                                                <i class="fas fa-times me-1"></i>Non réparable
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Expertise complémentaire</small>
                                        @if($exp->expertise_complementaire)
                                            <span class="badge bg-warning text-dark status-badge">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Requis
                                            </span>
                                        @else
                                            <span class="badge bg-secondary status-badge">
                                                <i class="fas fa-check me-1"></i>Non requis
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Analyse des dommages -->
                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="fas fa-search me-2 text-primary"></i>
                                            Analyse des dommages
                                        </h6>
                                        <div class="analysis-content">
                                            @if($exp->analyse_dommages)
                                                <p class="mb-0">{{ $exp->analyse_dommages }}</p>
                                            @else
                                                <p class="text-muted mb-0 fst-italic">Aucune analyse fournie</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Recommandations -->
                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="fas fa-lightbulb me-2 text-warning"></i>
                                            Recommandations
                                        </h6>
                                        <div class="recommendations-content">
                                            @if($exp->recommandations)
                                                <p class="mb-0">{{ $exp->recommandations }}</p>
                                            @else
                                                <p class="text-muted mb-0 fst-italic">Aucune recommandation fournie</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Métadonnées -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                       
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Mise à jour: {{ $exp->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                <!-- Action -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                                       
                                        <small class="text-muted">
                                            <i class="fas fa-validate me-1"></i>
                                            <a href="#">
                                                Valider l'expertise
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        
    </div>
</div>

<style>
.expertise-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.expertise-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.analysis-content, .recommendations-content {
    max-height: 120px;
    overflow-y: auto;
    padding-right: 10px;
}

.analysis-content::-webkit-scrollbar,
.recommendations-content::-webkit-scrollbar {
    width: 4px;
}

.analysis-content::-webkit-scrollbar-track,
.recommendations-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.analysis-content::-webkit-scrollbar-thumb,
.recommendations-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.analysis-content::-webkit-scrollbar-thumb:hover,
.recommendations-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.status-badge {
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 20px;
}

@media (max-width: 768px) {
    .expertise-card .card-body .row > div {
        margin-bottom: 1rem;
    }
    
    .analysis-content, .recommendations-content {
        max-height: none;
    }
}
</style>

<script>
// Initialiser les tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
    </div>
</div>


@endsection