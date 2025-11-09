@extends('templates.navbar2')

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
    <!-- En-tête  -->
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

    <!-- Alert documents manquants  -->
    @if($manquants->isNotEmpty())
        <div class="alert bg-light border-start border-4 border-danger shadow-sm p-4 mb-4 rounded-3">
            <div class="d-flex align-items-start mb-3">
                <div class="me-3 text-danger">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-semibold mb-1 text-danger">Documents manquants</h5>
                    <p class="text-muted mb-0">Les documents suivants sont requis pour finaliser le traitement :</p>
                </div>
            </div>

            <div class="row g-2">
                @foreach($manquants as $doc)
                    @if(array_key_exists($doc, $nomsDocuments))
                        <div class="col-md-6 col-lg-4">
                            <div class="d-flex align-items-center bg-white border rounded-3 p-2 small shadow-sm">
                                <i class="fas fa-file-alt text-secondary me-2"></i>
                                <span>{{ $nomsDocuments[$doc] }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
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

    <!-- Onglets   -->
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
            <button class="nav-link" id="passage-tab" data-bs-toggle="tab" data-bs-target="#passage" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Passagers
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
            <button class="nav-link" id="expertise-tab" data-bs-toggle="tab" data-bs-target="#expertise" type="button" role="tab">
                <i class="fas fa-tools me-2"></i>Expertise
            </button>
        </li>
        
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="sinistreTabsContent">

        <!-- Infos Sinistre  -->
        @include('gestionnaires.partials.informations')
        <!-- Assuré principal  -->
        @include('gestionnaires.partials.assure_principal')
         <!-- Assuré tiers  -->
        @include('gestionnaires.partials.assure_tiers')
         <!-- Documents  -->
        @include('gestionnaires.partials.documents')
         <!-- Expertise -->
        @include('gestionnaires.partials.expertise')
         <!-- Passagers  -->
        @include('gestionnaires.partials.passages')

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
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // URL de base (générée côté serveur pour gérer les préfixes)
    const basePassageUrl = "{{ url('passage') }}";

    // ----------------- MODAL MODIFIER -----------------
    const modifierModal = document.getElementById('modifierPassagerModal');
    if (modifierModal) {
        modifierModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');

            // éléments du formulaire
            const form = this.querySelector('#formModifierPassager');
            const inputId = this.querySelector('#edit_id_passager');
            const inputNom = this.querySelector('#edit_nom_passager');
            const inputPrenom = this.querySelector('#edit_prenom_passager');
            const inputDate = this.querySelector('#edit_date_naissance_passager');
            const selectType = this.querySelector('#edit_type_passager');

            // remplir les champs
            if (inputId) inputId.value = id ?? '';
            if (inputNom) inputNom.value = button.getAttribute('data-nom') ?? '';
            if (inputPrenom) inputPrenom.value = button.getAttribute('data-prenom') ?? '';
            if (inputDate) inputDate.value = button.getAttribute('data-date') ?? '';
            if (selectType) selectType.value = button.getAttribute('data-type') ?? '';

            // mettre à jour l’action du formulaire
            if (form && id) {
                form.action = `${basePassageUrl}/${id}`;
            }
        });
    }

    // ----------------- MODAL CONSULTER (avec AJAX) -----------------
    const consulterModal = document.getElementById('consulterPassagerModal');
    if (consulterModal) {
        consulterModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nomField = this.querySelector('#consulterNom');
            const prenomField = this.querySelector('#consulterPrenom');
            const dateField = this.querySelector('#consulterDate');
            const typeField = this.querySelector('#consulterType');
            const documentsList = this.querySelector('#consulterDocuments');

            // Réinitialiser les champs avant chargement
            nomField.textContent = 'Chargement...';
            prenomField.textContent = '';
            dateField.textContent = '';
            typeField.textContent = '';
            documentsList.innerHTML = '<li class="list-group-item text-muted">Chargement...</li>';

            // Appel AJAX
            fetch(`${basePassageUrl}/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    const { passage, documents } = data;

                    // Remplir les infos du passager
                    nomField.textContent = passage.nom_passager ?? '';
                    prenomField.textContent = passage.prenom_passager ?? '';
                    dateField.textContent = passage.date_naissance_passager ?? '';
                    typeField.textContent = passage.type_passager ?? '';

                    // Remplir les documents
                    if (documents.length > 0) {
                        documentsList.innerHTML = '';
                        documents.forEach(doc => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center';
                            li.innerHTML = `
                                <span>${doc.type_doc ?? 'Document'}</span>
                                <a href="/storage/${doc.path}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Télécharger
                                </a>
                            `;
                            documentsList.appendChild(li);
                        });
                    } else {
                        documentsList.innerHTML = '<li class="list-group-item text-muted">Aucun document disponible.</li>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    nomField.textContent = 'Erreur de chargement';
                    documentsList.innerHTML = '<li class="list-group-item text-danger">Impossible de charger les informations.</li>';
                });
        });
    }

    // ----------------- MODAL JOINDRE DOCUMENT -----------------
    const docModal = document.getElementById('ajouterDocumentModal');
    if (docModal) {
        docModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            this.querySelector('input[name="passage_id"]').value = button.getAttribute('data-id') ?? '';
        });
    }

    // ----------------- TOOLTIPS -----------------
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

@endsection