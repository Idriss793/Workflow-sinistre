@extends('layouts.app')
@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }

    .gradient-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .status-badge {
        background: var(--success-gradient);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .img-hover-zoom {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }

    .img-hover-zoom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        transform: translateX(-100%);
        transition: transform 0.6s;
        z-index: 1;
    }

    .img-hover-zoom:hover::before {
        transform: translateX(100%);
    }

    .img-hover-zoom:hover {
        transform: scale(1.08) rotate(2deg);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    .nav-tabs .nav-link {
        border: none;
        background: transparent;
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 2rem;
        margin-right: 0.5rem;
        border-radius: 15px 15px 0 0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .nav-tabs .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: var(--primary-gradient);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-tabs .nav-link.active {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-3px);
    }

    .nav-tabs .nav-link.active::before {
        width: 100%;
    }

    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        background: var(--danger-gradient);
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .document-status-item {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .document-status-item:hover {
        transform: translateX(10px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .document-status-item.available {
        border-left-color: #28a745;
        background: linear-gradient(135deg, #d4edda 0%, #f8fff8 100%);
    }

    .document-status-item.missing {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #f8d7da 0%, #fff8f8 100%);
    }

    .upload-zone {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px dashed #dee2e6;
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .upload-zone:hover {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
    }

    .btn-modern {
        background: var(--primary-gradient);
        border: none;
        border-radius: 25px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.8);
        padding: 1.5rem;
        border-radius: 15px;
        border-left: 4px solid #667eea;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: rgba(255, 255, 255, 0.95);
        transform: translateY(-2px);
    }

    .photo-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .photo-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        aspect-ratio: 4/3;
    }

    .photo-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .table-modern {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .table-modern thead {
        background: var(--primary-gradient);
        color: white;
    }

    .table-modern th {
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern td {
        border: none;
        padding: 1rem;
        border-bottom: 1px solid #f8f9fa;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="container-fluid my-4">
    <!-- En-tête moderne -->
    <div class="gradient-header fade-in">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ url('/home') }}" class="btn btn-light btn-modern me-3">
                    <i class="fas fa-arrow-left me-2"></i> Retour
                </a>
                <div>
                    <h2 class="mb-1">Sinistre #{{$sinistres->numero_sinistre}}</h2>
                    <small class="opacity-75">Consultation détaillée</small>
                </div>
            </div>
            <span class="status-badge">{{ $sinistres->statut->lib_statut}}</span>
        </div>
    </div>

    <!-- Alert documents manquants modernisée -->
    @if($manquants->isNotEmpty())
        <div class="alert-modern fade-in" style="animation-delay: 0.1s;">
            <div class="d-flex align-items-start">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="fw-bold mb-2">⚠️ Documents manquants</h5>
                    <p class="mb-2">Les documents suivants sont requis pour finaliser le traitement :</p>
                    <div class="row">
                        @foreach($manquants as $doc)
                            @if(array_key_exists($doc, $nomsDocuments))
                                <div class="col-md-6 mb-2">
                                    <i class="fas fa-file-alt me-2"></i>{{ $nomsDocuments[$doc] }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Onglets modernisés -->
    <ul class="nav nav-tabs fade-in" id="sinistreTabs" role="tablist" style="animation-delay: 0.2s;">
        <li class="nav-item">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                <i class="fas fa-info-circle me-2"></i>Infos Sinistre
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-principal-tab" data-bs-toggle="tab" data-bs-target="#assure-principal" type="button" role="tab">
                <i class="fas fa-user me-2"></i>Assuré principal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-tiers-tab" data-bs-toggle="tab" data-bs-target="#assure-tiers" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Assuré tiers
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                <i class="fas fa-folder me-2"></i>Documents
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content py-4" id="sinistreTabsContent">

        <!-- Infos Sinistre -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="modern-card mb-4 fade-in" style="animation-delay: 0.3s;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: var(--primary-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Informations détaillées</h5>
                    <span class="badge bg-light text-dark">En traitement</span>
                </div>
                <div class="card-body p-4">
                    <div class="info-grid">
                        <div class="info-item">
                            <strong><i class="fas fa-calendar-alt me-2 text-primary"></i>Date du sinistre</strong><br>
                            <span class="fs-5">{{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y')}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-map-marker-alt me-2 text-danger"></i>Lieu du sinistre</strong><br>
                            <span class="fs-5">{{$sinistres->lieu}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-tag me-2 text-warning"></i>Type de sinistre</strong><br>
                            <span class="fs-5">{{$sinistres->type_sinistre}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-tasks me-2 text-success"></i>Statut</strong><br>
                            <span class="badge" style="background: var(--success-gradient); font-size: 1rem;">{{ $sinistres->statut->lib_statut}}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <strong><i class="fas fa-align-left me-2 text-info"></i>Description complète</strong><br>
                        <p class="mt-2 mb-0 fs-6">{{$sinistres->description}}</p>
                    </div>
                </div>
            </div>

            <div class="modern-card fade-in" style="animation-delay: 0.4s;">
                <div class="card-header" style="background: var(--success-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-camera me-2"></i>Galerie photos du sinistre</h5>
                </div>
                <div class="card-body p-4">
                    @if($sinistres->documents->whereIn('type_doc', ['photos'])->count() > 0)
                        <div class="photo-gallery">
                            @foreach($sinistres->documents->whereIn('type_doc', ['photos']) as $document)
                                @php
                                    $imgPath = ($document->path && file_exists(storage_path('app/public/' . $document->path)))
                                                ? asset('storage/' . $document->path)
                                                : asset('image/defaultimage.png');
                                @endphp
                                <div class="photo-card">
                                    <img src="{{ $imgPath }}" class="img-hover-zoom" alt="Photo du sinistre" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-src="{{ $imgPath }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucune photo disponible pour ce sinistre</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assuré principal -->
        <div class="tab-pane fade" id="assure-principal" role="tabpanel">
            @foreach ($sinistres->assurePrincipals as $assure)
            <div class="modern-card fade-in">
                <div class="card-header" style="background: var(--primary-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Assuré principal</h5>
                </div>
                <div class="card-body p-4">
                    <div class="info-grid">
                        <div class="info-item">
                            <strong><i class="fas fa-user me-2"></i>Nom complet</strong><br>
                            <span class="fs-5">{{$assure->nom}} {{$assure->prenom}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-phone me-2"></i>Téléphone</strong><br>
                            <span class="fs-5">{{$assure->num_tel}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-file-contract me-2"></i>Numéro de police</strong><br>
                            <span class="fs-5">{{$assure->num_pol}}</span>
                        </div>
                        <div class="info-item">
                            <strong><i class="fas fa-id-card me-2"></i>Matricule</strong><br>
                            <span class="fs-5">{{$assure->num_matri}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Assuré tiers -->
        <div class="tab-pane fade" id="assure-tiers" role="tabpanel">
            <div class="row g-4">
                @foreach ($sinistres->assureTiers as $assure_tiers)
                    <div class="col-lg-6">
                        <div class="modern-card h-100 fade-in">
                            <div class="card-header text-center" style="background: var(--warning-gradient); color: white; border-radius: 20px 20px 0 0;">
                                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Assuré tiers</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="info-item mb-3">
                                    <strong>👤 Nom complet</strong><br>
                                    {{$assure_tiers->nom_tiers}} {{$assure_tiers->prenom_tiers}}
                                </div>
                                <div class="info-item mb-3">
                                    <strong>📞 Téléphone</strong><br>
                                    {{$assure_tiers->num_tel_tiers}}
                                </div>
                                <div class="info-item mb-3">
                                    <strong>📋 N° Police</strong><br>
                                    {{$assure_tiers->num_pol_tiers}}
                                </div>
                                <div class="info-item">
                                    <strong>🔢 Matricule</strong><br>
                                    {{$assure_tiers->num_matri_tiers}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="modern-card h-100 fade-in" style="animation-delay: 0.1s;">
                            <div class="card-header text-center" style="background: var(--success-gradient); color: white; border-radius: 20px 20px 0 0;">
                                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Compagnie d'assurance</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="info-item mb-3">
                                    <strong>🏢 Compagnie</strong><br>
                                    {{$assure_tiers->nom_assurance_tiers}}
                                </div>
                                <div class="info-item">
                                    <strong>📍 Contact/Localisation</strong><br>
                                    {{$assure_tiers->contact_assurance_tiers}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Documents -->
        <div class="tab-pane fade" id="documents" role="tabpanel">
            <!-- État des documents -->
            <div class="modern-card mb-4 fade-in">
                <div class="card-header" style="background: var(--primary-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-clipboard-check me-2"></i>État des documents</h5>
                </div>
                <div class="card-body p-4">
                    <div class="document-status-item available">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-camera me-2"></i>Photos des dégâts</span>
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="document-status-item missing">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-file-signature me-2"></i>Constat amiable signé</span>
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                    <div class="document-status-item available">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-car me-2"></i>Copie de la carte grise</span>
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                    <div class="document-status-item missing">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-id-card me-2"></i>Relevé d'informations permis</span>
                            <i class="fas fa-times-circle text-danger fa-lg"></i>
                        </div>
                    </div>
                    <div class="document-status-item available">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calculator me-2"></i>Devis de réparation</span>
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents téléversés -->
            @if ($sinistres->documents && $sinistres->documents->count())
            <div class="modern-card mb-4 fade-in" style="animation-delay: 0.2s;">
                <div class="card-header" style="background: var(--success-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Documents téléversés</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-tag me-2"></i>Type</th>
                                    <th><i class="fas fa-file me-2"></i>Nom</th>
                                    <th><i class="fas fa-weight me-2"></i>Taille</th>
                                    <th><i class="fas fa-calendar me-2"></i>Date</th>
                                    <th class="text-center"><i class="fas fa-cogs me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sinistres->documents as $document)
                                <tr>
                                    <td>
                                        <span class="badge" style="background: var(--primary-gradient);">
                                            {{$document->type_doc}}
                                        </span>
                                    </td>
                                    <td>{{$document->nom_fichier}}</td>
                                    <td>{{$document->taille}}</td>
                                    <td>{{\Carbon\Carbon::parse($document->created_at)->format('d/m/Y H:i')}}</td>
                                    <td class="text-center">
                                        <a href="{{asset('storage/' . $document->path)}}" target="_blank" class="btn btn-sm me-2" style="background: var(--success-gradient); color: white; border-radius: 15px;">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        <a href="{{asset('storage/' . $document->path)}}" download class="btn btn-sm" style="background: var(--primary-gradient); color: white; border-radius: 15px;">
                                            <i class="fas fa-download"></i> Télécharger
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Zone d'upload modernisée -->
            <div class="modern-card fade-in" style="animation-delay: 0.3s;">
                <div class="card-header" style="background: var(--warning-gradient); color: white; border-radius: 20px 20px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Ajouter un document</h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status'))
                        <div class="alert alert-success border-0 rounded-3 mb-4">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" class="row g-4" enctype="multipart/form-data" action="{{ route('document.store') }}">
                        @csrf
                        <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? old('sinistre_id') }}">
                        
                        <div class="col-md-3">
                            <label for="documentType" class="form-label fw-bold">
                                <i class="fas fa-tags me-2"></i>Type de document
                            </label>
                            <select class="form-select rounded-3" id="documentType" name="type_doc" required>
                                <option value="" disabled {{ old('type_doc') ? '' : 'selected' }}>Sélectionner...</option>
                                <option value="constat" {{ old('type_doc') == 'constat' ? 'selected' : '' }}>Constat amiable</option>
                                <option value="photos" {{ old('type_doc') == 'photos' ? 'selected' : '' }}>Photos</option>
                                <option value="permis" {{ old('type_doc') == 'permis' ? 'selected' : '' }}>Relevé permis</option>
                                <option value="carte_grise" {{ old('type_doc') == 'carte_grise' ? 'selected' : '' }}>Carte grise</option>
                                <option value="devis" {{ old('type_doc') == 'devis' ? 'selected' : '' }}>Devis</option>
                                <option value="contrat" {{ old('type_doc') == 'contrat' ? 'selected' : '' }}>Contrat Assuré</option>
                                <option value="autre" {{ old('type_doc') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="formFile" class="form-label fw-bold">
                                <i class="fas fa-paperclip me-2"></i>Fichier
                            </label>
                            <input class="form-control rounded-3" type="file" id="formFile" name="path" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        </div>
                        
                        <div class="col-md-3">
                            <label for="nom_fichier" class="form-label fw-bold">
                                <i class="fas fa-signature me-2"></i>Nom du document
                            </label>
                            <input class="form-control rounded-3" type="text" id="nom_fichier" name="nom_fichier" placeholder="Nom descriptif...">
                        </div>
                        
                        <div class="col-md-2 d-grid">
                            <label class="form-label invisible">Action</label>
                            <button type="submit" class="btn btn-modern">
                                <i class="fas fa-plus me-2"></i>Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour l'affichage des images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px