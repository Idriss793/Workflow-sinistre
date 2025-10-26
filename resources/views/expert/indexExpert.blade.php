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

        <!-- ====== Tableau des sinistres ====== -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="sinistresTable">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>N° Sinistre</th>
                                <th>Date</th>
                                <th>Assuré</th>
                                <th>Statut</th>
                                <th>Rapport</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="text-center" id="sinistresTableBody">
                            @if($sinistres->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucun sinistre à expertiser pour le moment.
                                    </td>
                                </tr>
                            @else
                                @foreach ($sinistres as $sinistre)
                                    <tr>
                                        <td>{{ $sinistre->numero_sinistre }}</td>
                                        <td>{{ $sinistre->created_at->format('d/m/Y') }}</td>

                                        @foreach ($sinistre->assurePrincipals as $assure)
                                            <td>{{ $assure->nom }}</td>
                                        @endforeach

                                        <td>
                                            <span class="badge bg-warning">{{ $sinistre->statut->lib_statut }}</span>
                                        </td>

                                        <td>
                                            @if ($sinistre->expertise)
                                                <span class="badge bg-success">Envoyé</span>
                                            @else
                                                <span class="badge bg-secondary">Non envoyé</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('expert.show', $sinistre->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> Consulter
                                            </a>

                                            <button class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rapportModal{{ $sinistre->id }}">
                                                <i class="fas fa-file-earmark-plus"></i> Envoyer rapport
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- ====== Modal Rapport pour ce sinistre ====== -->
                                    <div class="modal fade" id="rapportModal{{ $sinistre->id }}" tabindex="-1"
                                        aria-labelledby="rapportModalLabel{{ $sinistre->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <div class="container mt-4">
                                                    <div class="card shadow-sm border-0 rounded-3">
                                                        <div class="card-header bg-primary text-white">
                                                            <h5 class="mb-0">
                                                                <i class="fas fa-car-crash me-2"></i>
                                                                Soumettre un rapport d'expertise
                                                            </h5>
                                                        </div>

                                                        <div class="card-body">
                                                            @if ($errors->any())
                                                                <div class="alert alert-danger">
                                                                    <ul class="mb-0">
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            @endif

                                                            <form method="POST" action="{{ route('expert.storeExpertise') }}" enctype="multipart/form-data">
                                                                @csrf

                                                                <!-- ID du sinistre -->
                                                                <input type="hidden" name="sinistre_id" value="{{ $sinistre->id }}">

                                                                <!-- Estimation -->
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">
                                                                        <i class="fas fa-money-bill-wave me-1 text-primary"></i>
                                                                        Estimation des dégâts (en FCFA)
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="number" name="estimation_degats" class="form-control"
                                                                            placeholder="Ex : 1500000" step="0.01" required>
                                                                        <span class="input-group-text">FCFA</span>
                                                                    </div>
                                                                </div>

                                                                <!-- Fichier expertise -->
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold">
                                                                        <i class="fas fa-file-upload me-1 text-primary"></i>
                                                                        Joindre le rapport d'expertise (PDF)
                                                                    </label>
                                                                    <input type="file" name="expertise_path" accept=".pdf" class="form-control" required>
                                                                    <div class="form-text text-muted">Formats acceptés : PDF uniquement</div>
                                                                </div>

                                                                <!-- Bouton d’envoi -->
                                                                <div class="text-end">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        <i class="fas fa-paper-plane me-2"></i>Envoyer le rapport
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- ====== Fin du Modal ====== -->
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- ====== Fin du tableau ====== -->

    </div>
    </div>
@endsection