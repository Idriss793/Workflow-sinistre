@extends('layouts.app')
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
        <!-- Carte : Sinis tres déclarés -->
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres déclarés</h6>
                            <h2 class="mt-2 mb-0">45</h2>
                            <p class="mb-0"><small>Ce mois-ci</small></p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carte : Sinistres clôturés -->
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres clôturés</h6>
                            <h2 class="mt-2 mb-0">28</h2>
                            <p class="mb-0"><small>Ce mois-ci</small></p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carte : Taux de clôture -->
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Taux de clôture</h6>
                            <h2 class="mt-2 mb-0">62%</h2>
                            <p class="mb-0"><small>Performance</small></p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Carte : En attente validation -->
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">En attente validation</h6>
                            <h2 class="mt-2 mb-0">12</h2>
                            <p class="mb-0"><small>À traiter</small></p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="row mb-4 mt-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un sinistre...">
            </div>
        </div>
        <div class="col-md-3">
            <select class="form-select" id="statusFilter">
                <option value="">Tous les statuts</option>
                <option value="en_attente_de_ducument">En attente de ducument</option>
                <option value="en_attente_expertise">En attente attente d'expertise</option>
                <option value="en_attente_expertise">En attente d'expert</option>
                <option value="en_cours_expertise">En cours d'expertise</option>
                <option value="en_attente_validation">En attente validation</option>
                <option value="rejete">Rejeté</option>
                <option value="cloture">Clôturé</option>
            </select>
        </div>
        
        <div class="col-md-2">
            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#addSinistreModal">
                <i class="fas fa-plus me-1"></i>Nouveau
            </button>
        </div>
    </div>

    <!-- Tableau des sinistres -->
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
                        @foreach ($sinistres as $sinistre)
                            <tr>
                                <td>{{$sinistre->numero_sinistre}}</td>
                                <td>{{$sinistre->created_at}}</td>
                                @foreach ($sinistre->assurePrincipals as $assure)
                                    <td>{{ $assure->nom }}</td>
                                @endforeach
                                <td>{{ $sinistre->statut->lib_statut }}</td>
                                <td>Martin</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{route('gestionnaire.showSinistre',$sinistre->id)}}">
                                        <i class="bi bi-eye" >Consulter</i>
                                    </a>
                                    <a class="btn btn-sm btn-success">
                                        <i class="bi bi-user-check"></i> Attribuer à un expert
                                    </a>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection