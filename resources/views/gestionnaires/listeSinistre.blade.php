@extends('templates.navbar2')





@section('content')
<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
<!-- Dashboard avec indicateurs -->
<div class="container mt-5">
    <div class="row mb-5">
        <form method="GET" action="{{ route('gestionnaire.home') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label for="periode">Période :</label>
                    <select name="periode" id="periode" class="form-select">
                        <option value="1_semaine" {{ request('periode') == '1_semaine' ? 'selected' : '' }}>Dernière semaine</option>
                        <option value="1_mois" {{ request('periode') == '1_mois' ? 'selected' : '' }}>Dernier mois</option>
                        <option value="3_mois" {{ request('periode') == '3_mois' ? 'selected' : '' }}>3 derniers mois</option>
                        <option value="1_an" {{ request('periode') == '1_an' ? 'selected' : '' }}>Dernière année</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="mois">Mois spécifique :</label>
                    <select name="mois" id="mois" class="form-select">
                        <option value="">-- Tous les mois --</option>
                        @foreach (range(1, 12) as $mois)
                            <option value="{{ $mois }}" {{ request('mois') == $mois ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($mois)->locale('fr')->monthName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title mb-0">Sinistres déclarés</h6>
                    <h2 class="mt-2 mb-0">{{ $sinistres_declares }}</h2>
                    <p class="mb-0"><small>---------</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title mb-0">Sinistres clôturés</h6>
                    <h2 class="mt-2 mb-0">{{ $sinistres_clotures }}</h2>
                    <p class="mb-0"><small>---------</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title mb-0">Taux de clôture</h6>
                    <h2 class="mt-2 mb-0">{{ $taux_cloture }}%</h2>
                    <p class="mb-0"><small>Performance</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h6 class="card-title mb-0">En attente validation</h6>
                    <h2 class="mt-2 mb-0">{{ $en_attente }}</h2>
                    <p class="mb-0"><small>À traiter</small></p>
                </div>
            </div>
        </div>
    </div>



    <div class="row mb-4 mt-4">
        
        <!-- Filtres et recherche -->
        <form method="GET" action="{{ route('gestionnaire.home') }}">
            <div class="row mb-4 mt-4">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Rechercher un sinistre...">
                    </div>
                </div>
                <!-- Filtre statut -->
                <div class="col-md-3">
                    <select class="form-select" name="statut" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="1" {{ request('statut')=='1' ? 'selected' : '' }}>En attente de document</option>
                        <option value="2" {{ request('statut')=='2' ? 'selected' : '' }}>En attente expert</option>
                        <option value="3" {{ request('statut')=='3' ? 'selected' : '' }}>En attente expertise</option>
                        <option value="6" {{ request('statut')=='6' ? 'selected' : '' }}>En attente de validation</option>
                        <option value="4" {{ request('statut')=='4' ? 'selected' : '' }}>Rejeté</option>
                        <option value="5" {{ request('statut')=='5' ? 'selected' : '' }}>Validé</option>
                        <option value="7" {{ request('statut')=='7' ? 'selected' : '' }}>Clôturé</option>
                    </select>
                </div>

                <!-- Filtre type sinistre -->
                <div class="col-md-2">
                    <select class="form-select" name="type_sinistre" onchange="this.form.submit()">
                        <option value="">Tous types</option>
                        <option value="collision" {{ request('type_sinistre')=='type_sinistre' ? 'selected' : '' }}>Collision</option>
                        <option value="vol" {{ request('type_sinistre')=='vol' ? 'selected' : '' }}>Vole</option>
                        <option value="materiel" {{ request('type_sinistre')=='materiel' ? 'selected' : '' }}>Materiel</option>
                    </select>
                </div>

                <!-- Filtre par période -->
                <div class="col-md-2">
                    <input type="date" name="date_declaration" class="form-control" value="{{ request('date_declaration') }}"  onchange="this.form.submit()">
                </div>

            </div>
        </form>
        
        <div class="col-md-2">
            <a href="{{url('formSinistre')}}" class="btn btn-success w-100">
                <i class="fas fa-plus me-1"></i>Nouveau
            </a>
        </div>
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show m-3 p-2" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('status') }}
            </div>
        @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3 p-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Tableau des sinistres -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="sinistresTable">
                    <thead class="table-dark text-center">
                        <tr>
                            <th class="sortable" data-sort="numero">
                                N° Sinistre <i class="fas fa-sort sort-arrow"></i>
                            </th>
                            <th class="sortable" data-sort="date">
                                Date <i class="fas fa-sort sort-arrow"></i>
                            </th>
                            <th>Assuré</th>
                            <th>Type de sinistre</th>
                            <th class="sortable" data-sort="statut">
                                Statut <i class="fas fa-sort sort-arrow"></i>
                            </th>
                            <th>Expert</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="sinistresTableBody">
                        @forelse ($sinistres as $sinistre)
                            <tr>
                                <td>{{ $sinistre->numero_sinistre }}</td>
                                <td>{{ $sinistre->created_at->format('d/m/Y H:i') }}</td>
                                @foreach ($sinistre->assurePrincipals as $assure)
                                    <td>{{ $assure->nom }}</td>
                                @endforeach
                                <td>{{ $sinistre->type_sinistre }}</td>
                                <td>
                                    @php
                                        $statut = strtolower($sinistre->statut->lib_statut);
                                        switch ($statut) {
                                            case 'en attente de document':
                                                $badgeClass = 'bg-warning text-dark';
                                                $icon = 'fa-file-alt';
                                                break;
                                            case 'en attente d\'expert':
                                                $badgeClass = 'bg-info text-dark';
                                                $icon = 'fa-user-clock';
                                                break;
                                            case 'en attente d\'expertise':
                                                $badgeClass = 'bg-primary';
                                                $icon = 'fa-search';
                                                break;
                                            case 'en attente de validation':
                                                $badgeClass = 'bg-secondary';
                                                $icon = 'fa-hourglass-half';
                                                break;
                                            case 'valider':
                                            case 'validé':
                                                $badgeClass = 'bg-success';
                                                $icon = 'fa-check-circle';
                                                break;
                                            case 'rejeter':
                                            case 'rejeté':
                                                $badgeClass = 'bg-danger';
                                                $icon = 'fa-times-circle';
                                                break;
                                            case 'clôturé':
                                            case 'cloture':
                                            case 'clos':
                                                $badgeClass = 'bg-dark';
                                                $icon = 'fa-lock';
                                                break;
                                            default:
                                                $badgeClass = 'bg-light text-dark';
                                                $icon = 'fa-question-circle';
                                                break;
                                        }
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        <i class="fas {{ $icon }}"></i> {{ ucfirst($sinistre->statut->lib_statut) }}
                                    </span>
                                </td>

                                <td>
                                    @if($sinistre->experts->isEmpty())
                                        <span class="text-muted"><i class="fas fa-user-times"></i> Non attribué</span>
                                    @elseif($sinistre->experts->count() === 1)
                                        <span class="badge bg-success">
                                            <i class="fas fa-user-tie"></i> {{ $sinistre->experts->first()->name }}
                                        </span>
                                    @else
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-users"></i> {{ $sinistre->experts->count() }} Experts
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach($sinistre->experts as $expert)
                                                    <li><span class="dropdown-item">{{ $expert->name }}</span></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-sm btn-primary" href="{{ route('gestionnaire.showSinistre',$sinistre->id) }}" 
                                        data-bs-toggle="tooltip" title="Consulter le sinistre">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" 
                                                data-bs-target="#listExpertModal-{{ $sinistre->id }}" 
                                                data-bs-toggle="tooltip" title="Attribuer à un expert">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-lg"></i> Aucun sinistre trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($sinistres->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        {{ $sinistres->links() }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modaux des experts -->
    @foreach($sinistres as $sinistre)
        <div class="modal fade" id="listExpertModal-{{ $sinistre->id }}" tabindex="-1" aria-labelledby="listExpertModalLabel-{{ $sinistre->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Attribuer à un expert – Sinistre #{{ $sinistre->numero_sinistre }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Sinistres en cours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($experts as $expert)
                                    <tr>
                                        <td>{{ $expert->name }}</td>
                                        <td>{{ $expert->email }}</td>
                                        <td><span class="badge bg-secondary">{{$expert->sinistres_en_cours_de_traitement ?? 0}} </span></td>
                                        <td>
                                            @if ($sinistre->experts->contains($expert->id))
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Déjà attribué" disabled>
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                    <form method="GET" action="{{ route('expert.annulerExpert',  [$sinistre->id, $expert->id]) }}">
                                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Annuler l'attribution">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <form action="{{ route('expert.attribuerExpert', $sinistre->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="expert_id" value="{{ $expert->id }}">
                                                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" title="Attribuer à cet expert">
                                                        <i class="fas fa-user-plus"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="fas fa-info-circle fa-lg"></i> Aucun expert disponible
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Script pour affichage message aucun résultat -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('sinistresTable');
        const tbody = document.getElementById('sinistresTableBody');
        const rows = tbody.getElementsByTagName('tr');

        // Ajout du tooltip bootstrap
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Message dynamique si aucun résultat
        const observer = new MutationObserver(() => {
            const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none');
            if (visibleRows.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-lg"></i> Aucun résultat trouvé
                        </td>
                    </tr>
                `;
            }
        });

        observer.observe(tbody, { childList: true, subtree: true });
    });
    </script>
@endsection