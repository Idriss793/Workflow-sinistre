@extends('templates.navbar')
@section('content')
<div class="main-content" id="mainContent">
    <div class="container mt-5">
        <!-- Statistiques -->
        <div class="row mb-5">
            <!-- Carte : Sinistres à traiter -->
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
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
            </div>

            <!-- Carte : Sinistres traités -->
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
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
                
            </div>

        <!-- Tableau des sinistres -->
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
                            <tr>
                                <td>SIN-01</td>
                                <td>20-10-24</td>
                                <td>Jean</td>
                                <td><span class="badge bg-warning">En attente d'expertise</span></td>
                                <td><span class="badge bg-secondary">Non envoyé</span></td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="#">
                                        <i class="bi bi-eye"></i> Consulter
                                    </a>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#rapportModal">
                                        <i class="bi bi-file-earmark-plus"></i> Envoyer rapport
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rapport -->
<div class="modal fade" id="rapportModal" tabindex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="rapportModalLabel">Envoyer le rapport d'expertise</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <!-- Upload de fichier -->
          <div class="mb-3">
            <label for="rapportFile" class="form-label">Joindre un fichier (PDF, DOCX)</label>
            <input type="file" name="rapportFile" id="rapportFile" class="form-control">
          </div>

          <hr class="my-3">

          <!-- Rédiger le rapport -->
          <div class="mb-3">
            <label for="observations" class="form-label">Observations</label>
            <textarea name="observations" id="observations" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label for="estimation" class="form-label">Estimation des réparations (€)</label>
            <input type="number" name="estimation" id="estimation" class="form-control">
          </div>

          <div class="mb-3">
            <label for="conclusion" class="form-label">Conclusion</label>
            <select name="conclusion" id="conclusion" class="form-select">
              <option value="reparable">Réparable</option>
              <option value="epave">Épave</option>
              <option value="a_completer">À compléter</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Envoyer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
