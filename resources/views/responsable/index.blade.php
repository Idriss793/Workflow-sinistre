@extends('templates.navbar3')
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



<div class="main-content" id="mainContent">
    <div class="container mt-5">
        <!-- Dahsboard -->
            <div class="row mb-5">
                <form method="GET" action="{{ route('responsable.search') }}" class="mb-4">
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

            <!-- Filtres et recherche -->
            <form method="GET" action="{{ route('responsable.search') }}">
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
                            <option value="6"
                                    {{ request('statut') == '6' ? 'selected' : '' }}>
                                    En attente de validation
                            </option>                            <option value="4" {{ request('statut')=='4' ? 'selected' : '' }}>Rejeté</option>
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
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="sinistresTable">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th class="sortable" data-sort="numero">
                                        N° Sinistre <i class="fas fa-sort sort-arrow"></i>
                                    </th>
                                    <th class="sortable" data-sort="date">
                                        Date <i class="fas fa-sort sort-arrow"></i>
                                    </th>
                                    <th>Assuré</th>
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
                                    <td>{{ $sinistre->created_at }}</td>
                                    @foreach ($sinistre->assurePrincipals as $assure)
                                        <td>{{ $assure->nom }}</td>
                                    @endforeach
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
                                        @if ($sinistre->experts && $sinistre->experts->count() > 0)
                                            {{ $sinistre->experts->pluck('name')->join(', ') }}
                                        @else
                                            <span class="text-muted">Aucun expert</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Bouton Consulter -->
                                        <a class="btn btn-sm btn-primary" 
                                        href="{{ route('responsable.show', $sinistre->id) }}"
                                        data-bs-toggle="tooltip" 
                                        title="Consulter">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                       

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle fa-lg"></i>
                                        Aucun sinistre trouvé
                                        @if(request()->has('search') || request()->has('statut') || request()->has('type_sinistre') || request()->has('date_declaration'))
                                            pour cette recherche ou ce filtre.
                                        @else
                                            pour le moment.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>


                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                {{ $sinistres->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>


@endpush