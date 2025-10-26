<div class="tab-pane fade" id="assure-tiers" role="tabpanel">
    <div class="card card-clean">
        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users me-2"></i>Liste des assurés tiers impliqués</h5>
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#ajouterAssureTiersModal">
                <i class="fas fa-plus me-1"></i> Ajouter
            </button>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom complet</th>
                        <th>Téléphone</th>
                        <th>Numéro de police</th>
                        <th>Matricule véhicule</th>
                        <th>Compagnie d’assurance</th>
                        <th>Contact assurance</th>
                     
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sinistres->assureTiers as $index => $assure_tiers)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $assure_tiers->prenom_tiers }} {{ $assure_tiers->nom_tiers }}</td>
                        <td>{{ $assure_tiers->num_tel_tiers }}</td>
                        <td>{{ $assure_tiers->num_pol_tiers }}</td>
                        <td>{{ $assure_tiers->num_matri_tiers }}</td>
                        <td>{{ $assure_tiers->nom_assurance_tiers }}</td>
                        <td>{{ $assure_tiers->contact_assurance_tiers }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modifierAssureTiersModal{{ $assure_tiers->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Modal de modification -->
                    <div class="modal fade" id="modifierAssureTiersModal{{ $assure_tiers->id }}" tabindex="-1" aria-labelledby="modifierAssureTiersModalLabel{{ $assure_tiers->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modifierAssureTiersModalLabel{{ $assure_tiers->id }}">Modifier Assuré Tiers</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <form action="{{ route('assureTiers.update',$assure_tiers->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nom</label>
                                            <input type="text" name="nom_tiers" value="{{ $assure_tiers->nom_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Prénom</label>
                                            <input type="text" name="prenom_tiers" value="{{ $assure_tiers->prenom_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Téléphone</label>
                                            <input type="text" name="num_tel_tiers" value="{{ $assure_tiers->num_tel_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Numéro de police</label>
                                            <input type="text" name="num_pol_tiers" value="{{ $assure_tiers->num_pol_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Matricule véhicule</label>
                                            <input type="text" name="num_matri_tiers" value="{{ $assure_tiers->num_matri_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Compagnie d’assurance</label>
                                            <input type="text" name="nom_assurance_tiers" value="{{ $assure_tiers->nom_assurance_tiers }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact assurance</label>
                                            <input type="text" name="contact_assurance_tiers" value="{{ $assure_tiers->contact_assurance_tiers }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Aucun assuré tiers enregistré.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Modal d'ajout d'un assuré tiers -->
    <div class="modal fade" id="ajouterAssureTiersModal" tabindex="-1" aria-labelledby="ajouterAssureTiersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouterAssureTiersModalLabel">Ajouter un Assuré Tiers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form action="{{ route('assureTiers.ajouter') }}" method="POST">
                    @csrf
                    <input type="hidden", name="id" value="{{ $sinistres->id }}">
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label    ">Nom</label>
                            <input type="text" name="nom_tiers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom_tiers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="num_tel_tiers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Numéro de police</label>
                            <input type="text" name="num_pol_tiers" class="form-control"    required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Matricule véhicule</label>
                            <input type="text" name="num_matri_tiers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Compagnie d’assurance</label>
                            <input type="text" name="nom_assurance_tiers" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact assurance</label>
                            <input type="text" name="contact_assurance_tiers" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>