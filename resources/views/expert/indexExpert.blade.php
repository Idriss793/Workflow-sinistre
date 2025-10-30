@extends('templates.navbar1')


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
    <div class="main-content" id="mainContent"> <div class="container mt-5">
        <!-- ====== Statistiques ====== -->
            <div class="row mb-5">
                <form method="GET" action="{{ route('expert.search') }}" class="mb-4">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label for="periode">Période :</label>
                            <select name="periode" id="periode" class="form-select">
                                <option value="semaine" {{ request('periode') == 'semaine' ? 'selected' : '' }}>Dernière semaine</option>
                                <option value="mois" {{ request('periode') == 'mois' ? 'selected' : '' }}>Dernier mois</option>
                                <option value="3mois" {{ request('periode') == '3mois' ? 'selected' : '' }}>3 derniers mois</option>
                                <option value="an" {{ request('periode') == 'an' ? 'selected' : '' }}>Dernière année</option>
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
            <!-- Sinistres à traiter -->
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres à traiter</h6>
                            <h2 class="mt-2 mb-0">{{ $a_traiter }}</h2>
                      
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinistres traités -->
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres traités</h6>
                            <h2 class="mt-2 mb-0">{{ $traites }}</h2>
                           
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinistres validés -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres traités et validés</h6>
                            <h2 class="mt-2 mb-0">{{ $valide }}</h2>
                            
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sinistres rejetés -->
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Sinistres traités et rejetés</h6>
                            <h2 class="mt-2 mb-0">{{ $rejete }}</h2>
                           
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====== Filtres et recherche ====== -->
        
        <div class="row mb-4 mt-4">
            
            <!-- Filtres et recherche -->
            <form method="GET" action="{{ route('expert.search') }}">
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
     
                            <option value="3" {{ request('statut')=='3' ? 'selected' : '' }}>En attente expertise</option>
                            <option value="6" {{ request('statut')=='6' ? 'selected' : '' }}>En attente de validation</option>
                            <option value="4" {{ request('statut')=='4' ? 'selected' : '' }}>Rejeté</option>
                            <option value="5" {{ request('statut')=='5' ? 'selected' : '' }}>Validé</option>
                            <option value="7" {{ request('statut')=='7' ? 'selected' : '' }}>Clôturé</option>
                        </select>
                    </div>

                   

                    <!-- Filtre par période -->
                    <div class="col-md-2">
                        <input type="date" name="date_declaration" class="form-control" value="{{ request('date_declaration') }}"  onchange="this.form.submit()">
                    </div>

                </div>
            </form>
            
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