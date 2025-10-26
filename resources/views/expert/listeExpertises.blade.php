@extends('templates.navbar1')


@section('content')

    <div class="main-content" id="mainContent"> <div class="container mt-5">
    <!-- ====== Statistiques ====== -->
        <div class="row mb-5">
            <!-- Carte : Sinistres à traiter -->
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres à traiter</h6>
                            <h2 class="mt-2 mb-0">45</h2>
                            <p class="mb-0"><small>Ce mois-ci</small></p>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte : Sinistres traités -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres traités</h6>
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

        <!-- ====== Filtres et recherche ====== -->
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
                    <option value="rejeter">Rejeté</option>
                    <option value="valider">validé</option>
                </select>
            </div>
        </div>

       <!-- ====== Tableau des expertises ====== -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="expertisesTable">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>N° Sinistre</th>
                                <th>Date d'envoie</th>
                                <th>Assuré</th>
                                <th>Statut</th>
                                <th>Rapport</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-center" id="expertisesTableBody">
                            @if($expertises->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucune expertise pour le moment.
                                    </td>
                                </tr>
                            @else
                                @foreach ($expertises as $expertise)
                                    <tr>
                                        <td>{{ $expertise->sinistre->numero_sinistre ?? 'N/A' }}</td>
                                        <td>{{ $expertise->created_at->format('d/m/Y à H:i') }}</td>

                                        <td>
                                            @if ($expertise->sinistre && $expertise->sinistre->assurePrincipals->isNotEmpty())
                                                {{ $expertise->sinistre->assurePrincipals->first()->nom }}
                                            @else
                                                Non renseigné
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge
                                                @if($expertise->statut && $expertise->statut->lib_statut == 'Valider') bg-success
                                                @elseif($expertise->statut && $expertise->statut->lib_statut == 'En attente') bg-warning
                                                @else bg-secondary
                                                @endif">
                                                {{ $expertise->statut->lib_statut ?? 'Non défini' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($expertise->expertise_path)
                                                <a href="{{ asset('storage/' . $expertise->expertise_path) }}" target="_blank" class="text-decoration-none">
                                                    <i class="fas fa-file-pdf text-danger"></i> Voir
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Aucun fichier</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('expert.show', $expertise->sinistre_id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Consulter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($expertises->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $expertises->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
        <!-- ====== Fin du tableau ====== -->
     


    </div>
    </div>
@endsection