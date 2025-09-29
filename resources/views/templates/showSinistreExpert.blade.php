@extends('templates.navbar2')
@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .dashboard-header {
        background: var(--primary-gradient);
        border-radius: 15px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .stat-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .stat-card.primary {
        background: var(--primary-gradient);
    }

    .stat-card.success {
        background: var(--success-gradient);
    }

    .stat-card.warning {
        background: var(--warning-gradient);
    }

    .stat-card.info {
        background: var(--info-gradient);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .filter-section {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #e9ecef;
    }

    .search-input {
        border-radius: 25px;
        border: 2px solid #e9ecef;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .filter-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .sinistres-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        border: none;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border: none;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-en_attente_document { background: #fff3cd; color: #856404; }
    .status-en_attente_expertise { background: #d1ecf1; color: #0c5460; }
    .status-en_cours_expertise { background: #d4edda; color: #155724; }
    .status-rejete { background: #f8d7da; color: #721c24; }
    .status-cloture { background: #e2e3e5; color: #383d41; }

    .rapport-badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .rapport-non-envoye { background: #6c757d; color: white; }
    .rapport-envoye { background: #28a745; color: white; }
    .rapport-en-cours { background: #ffc107; color: #212529; }

    .action-btn {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        margin: 0 2px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-consulter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-rapport {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
        padding: 1.5rem 2rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: 1rem;
            text-align: center;
        }
        
        .stat-card {
            margin-bottom: 1rem;
        }

        .filter-section {
            padding: 1rem;
        }

        .table-responsive {
            font-size: 0.9rem;
        }

        .action-btn {
            padding: 6px 12px;
            font-size: 0.8rem;
        }
    }
</style>

<div class="main-content" id="mainContent">
    <div class="container-fluid mt-4">
        
        <!-- En-tête du dashboard -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Dashboard Expert Automobile
                    </h2>
                    <p class="mb-0 opacity-75">Gérez vos expertises de sinistres automobile</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques améliorées -->
        <div class="row mb-4">
            <!-- Sinistres à traiter -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1 opacity-75">Sinistres à traiter</h6>
                                <h2 class="mb-1 fw-bold">45</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-arrow-up me-1"></i>+12% ce mois
                                </small>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinistres traités -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1 opacity-75">Sinistres traités</h6>
                                <h2 class="mb-1 fw-bold">28</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-check me-1"></i>Ce mois-ci
                                </small>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- En cours d'expertise -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1 opacity-75">En cours</h6>
                                <h2 class="mb-1 fw-bold">12</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-clock me-1"></i>Expertises actives
                                </small>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-cogs fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rapports envoyés -->
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card stat-card info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-1 opacity-75">Rapports envoyés</h6>
                                <h2 class="mb-1 fw-bold">85</h2>
                                <small class="opacity-75">
                                    <i class="fas fa-paper-plane me-1"></i>Cette semaine: 15
                                </small>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Section filtres et recherche améliorée -->
        <div class="filter-section">
            <div class="row align-items-end">
                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                    <label class="form-label fw-semibold text-muted">
                        <i class="fas fa-search me-1"></i> Recherche
                    </label>
                    <div class="position-relative">
                        <input type="text" class="form-control search-input ps-5" id="searchInput" 
                               placeholder="N° sinistre, nom assuré...">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label class="form-label fw-semibold text-muted">
                        <i class="fas fa-filter me-1"></i> Statut
                    </label>
                    <select class="form-select filter-select" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente_document">En attente de document</option>
                        <option value="en_attente_expertise">En attente d'expertise</option>
                        <option value="en_cours_expertise">En cours d'expertise</option>
                        <option value="en_attente_validation">En attente validation</option>
                        <option value="rejete">Rejeté</option>
                        <option value="cloture">Clôturé</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label class="form-label fw-semibold text-muted">
                        <i class="fas fa-calendar me-1"></i> Période
                    </label>
                    <select class="form-select filter-select" id="periodFilter">
                        <option value="">Toutes les périodes</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                        <option value="quarter">Ce trimestre</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Tableau des sinistres amélioré -->
        <div class="card sinistres-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover" id="sinistresTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>N° Sinistre</th>
                                <th><i class="fas fa-calendar me-2"></i>Date</th>
                                <th><i class="fas fa-user me-2"></i>Assuré</th>
                                <th><i class="fas fa-info-circle me-2"></i>Type</th>
                                <th><i class="fas fa-traffic-light me-2"></i>Statut</th>
                                <th><i class="fas fa-file-alt me-2"></i>Rapport</th>
                                <th><i class="fas fa-cog me-2"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sinistresTableBody">
                            @forelse ($sinistres as $sinistre)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $sinistre->numero_sinistre }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($sinistre->created_at)->format('d/m/Y') }}</span>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($sinistre->created_at)->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($sinistre->assurePrincipals as $assure)
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ $assure->nom }}</span>
                                                <small class="text-muted">{{ $assure->num_tel }}</small>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $sinistre->type_sinistre ?? 'Automobile' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge status-badge status-{{ str_replace(' ', '_', strtolower($sinistre->statut->lib_statut)) }}">
                                            {{ $sinistre->statut->lib_statut }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rapport-badge rapport-non-envoye">
                                            <i class="fas fa-clock me-1"></i>Non envoyé
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a class="btn btn-sm action-btn btn-consulter" 
                                               href="{{ route('expert.show', $sinistre->id) }}"
                                               title="Consulter le sinistre">
                                                <i class="fas fa-eye me-1"></i> Voir
                                            </a>
                                            <button class="btn btn-sm action-btn btn-rapport" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rapportModal"
                                                    data-sinistre="{{ $sinistre->numero_sinistre }}"
                                                    title="Envoyer le rapport">
                                                <i class="fas fa-paper-plane me-1"></i> Rapport
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5 class="mt-3 mb-2">Aucun sinistre trouvé</h5>
                                            <p class="mb-0">Il n'y a aucun sinistre correspondant à vos critères de recherche.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sinistres->hasPages())
                <div class="pagination-wrapper">
                    {{ $sinistres->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Rapport Amélioré -->
<div class="modal fade" id="rapportModal" tabindex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rapportModalLabel">
                        <i class="fas fa-file-alt me-2"></i>
                        Rapport d'Expertise Automobile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Sinistre:</strong> <span id="sinistreNumber">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Méthode de soumission -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="method" id="methodFile" value="file" checked>
                                <label class="form-check-label fw-semibold" for="methodFile">
                                    <i class="fas fa-file-upload me-1"></i> Joindre un fichier
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="method" id="methodForm" value="form">
                                <label class="form-check-label fw-semibold" for="methodForm">
                                    <i class="fas fa-edit me-1"></i> Remplir le formulaire
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Section upload de fichier -->
                    <div id="fileSection">
                        <div class="mb-3">
                            <label for="rapportFile" class="form-label fw-semibold">
                                <i class="fas fa-paperclip me-1"></i> Rapport d'expertise (PDF, DOCX)
                            </label>
                            <input type="file" name="rapportFile" id="rapportFile" 
                                   class="form-control" accept=".pdf,.docx,.doc">
                            <div class="form-text">Formats acceptés: PDF, DOCX (max. 10MB)</div>
                        </div>
                    </div>

                    <!-- Section formulaire -->
                    <div id="formSection" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estimation" class="form-label fw-semibold">
                                    <i class="fas fa-euro-sign me-1"></i> Estimation (€)
                                </label>
                                <input type="number" name="estimation" id="estimation" 
                                       class="form-control" step="0.01" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="conclusion" class="form-label fw-semibold">
                                    <i class="fas fa-clipboard-check me-1"></i> Conclusion
                                </label>
                                <select name="conclusion" id="conclusion" class="form-select">
                                    <option value="">Sélectionner...</option>
                                    <option value="reparable">✅ Réparable</option>
                                    <option value="epave">❌ Épave économique</option>
                                    <option value="a_completer">⏳ À compléter</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observations" class="form-label fw-semibold">
                                <i class="fas fa-eye me-1"></i> Observations détaillées
                            </label>
                            <textarea name="observations" id="observations" 
                                      class="form-control" rows="4" 
                                      placeholder="Décrivez l'état du véhicule, les dommages constatés, les réparations nécessaires..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="securiteOk">
                                    <label class="form-check-label" for="securiteOk">
                                        Éléments de sécurité OK
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="expertiseComplete">
                                    <label class="form-check-label" for="expertiseComplete">
                                        Expertise complète effectuée
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Notes additionnelles -->
                    <div class="mb-3">
                        <label for="notes" class="form-label fw-semibold">
                            <i class="fas fa-sticky-note me-1"></i> Notes complémentaires
                        </label>
                        <textarea name="notes" id="notes" class="form-control" rows="2" 
                                  placeholder="Informations supplémentaires..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-1"></i> Envoyer le rapport
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des méthodes de soumission du rapport
    const methodFile = document.getElementById('methodFile');
    const methodForm = document.getElementById('methodForm');
    const fileSection = document.getElementById('fileSection');
    const formSection = document.getElementById('formSection');

    methodFile.addEventListener('change', function() {
        if (this.checked) {
            fileSection.style.display = 'block';
            formSection.style.display = 'none';
        }
    });

    methodForm.addEventListener('change', function() {
        if (this.checked) {
            fileSection.style.display = 'none';
            formSection.style.display = 'block';
        }
    });

    // Gestion du modal rapport
    const rapportModal = document.getElementById('rapportModal');
    rapportModal.addEventListener('show.bs.modal', function(e) {
        const button = e.relatedTarget;
        const sinistreNumber = button.getAttribute('data-sinistre');
        document.getElementById('sinistreNumber').textContent = sinistreNumber;
    });

    // Fonction de reset des filtres
    window.resetFilters = function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('periodFilter').value = '';
        // Ici vous pourriez ajouter la logique de filtrage
    };

    // Recherche en temps réel (à implémenter selon vos besoins)
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        // Logique de recherche
        console.log('Recherche:', this.value);
    });
});
</script>

@endsection