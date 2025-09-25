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

                                <!-- Récupération et affichage du nom de l'expert automobile -->
                                <td>
                                    @if($sinistre->experts->isEmpty())
                                        <span class="text-muted">Non attribué</span>
                                    @elseif($sinistre->experts->count() === 1)
                                        <span class="badge bg-success">{{ $sinistre->experts->first()->name }}</span>
                                    @else
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                {{ $sinistre->experts->count() }} Experts
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
                                    <a class="btn btn-sm btn-primary" href="{{route('gestionnaire.showSinistre',$sinistre->id)}}">
                                        <i class="bi bi-eye" >Consulter</i>
                                    </a>

                                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#listExpertModal-{{ $sinistre->id }}">
                                        <i class="bi bi-user-check"></i> Attribuer à un expert
                                    </a>
                                </td>
                            </tr>
                            
                        @endforeach
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

    <!-- Modal liste expert -->

    @foreach($sinistres as $sinistre)

    <div class="modal fade" id="listExpertModal-{{ $sinistre->id }}" tabindex="-1" aria-labelledby="listExpertModalLabel-{{ $sinistre->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attribuer à un expert – Sinistre #{{ $sinistre->numero_sinistre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
              
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Sinistres en cours</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($experts as $expert)
                                <tr>
                                    <td>{{ $expert->name }}</td>
                                    <td>{{ $expert->email }}</td>
                                    <td>13</td>
                                    <td>
                                        <!-- Attribuer un sinistre à un expert -->
                                        @if ($sinistre->experts->contains($expert->id))
                                            <button class="btn btn-sm btn-outline-success" disabled>
                                                <i class="bi bi-check-circle-fill">attribué"</i>
                                            </button>
                                        @else
                                            <form action="{{ route('expert.attribuerExpert', $sinistre->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="expert_id" value="{{ $expert->id }}">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-user-check"></i> Attribuer
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach




@endsection