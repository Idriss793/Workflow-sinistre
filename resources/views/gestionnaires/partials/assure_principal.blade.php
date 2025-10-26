<div class="tab-pane fade" id="assure-principal" role="tabpanel">
    @foreach ($sinistres->assurePrincipals as $assure)
    <div class="card card-clean">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-user-tie me-2"></i>Assuré principal
            </h5>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modifierAssureModal{{ $assure->id }}">
                <i class="fas fa-edit me-1"></i> Modifier
            </button>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item mb-3">
                        <label class="form-label text-muted small mb-1">Nom complet</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user text-primary me-2"></i>
                            <strong>{{ $assure->prenom }} {{ $assure->nom }}</strong>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <label class="form-label text-muted small mb-1">Téléphone</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-success me-2"></i>
                            <strong>{{ $assure->num_tel }}</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item mb-3">
                        <label class="form-label text-muted small mb-1">Numéro de police</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-contract text-info me-2"></i>
                            <strong>{{ $assure->num_pol }}</strong>
                        </div>
                    </div>
                    <div class="info-item mb-3">
                        <label class="form-label text-muted small mb-1">Matricule véhicule</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-car text-warning me-2"></i>
                            <strong>{{ $assure->num_matri }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Exemple de modal d’édition -->
    <div class="modal fade" id="modifierAssureModal{{ $assure->id }}" tabindex="-1" aria-labelledby="modifierAssureModalLabel{{ $assure->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifierAssureModalLabel{{ $assure->id }}">Modifier l’assuré principal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulaire d’édition -->
                    <form action="{{ route('assurePrincipal.update', $assure->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" value="{{ $assure->nom }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" value="{{ $assure->prenom }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="num_tel" value="{{ $assure->num_tel }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Numéro de police</label>
                            <input type="text" name="num_pol" value="{{ $assure->num_pol }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Matricule véhicule</label>
                            <input type="text" name="num_matri" value="{{ $assure->num_matri }}" class="form-control">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
