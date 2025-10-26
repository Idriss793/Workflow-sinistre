<!-- ========== MODAL AJOUT PASSAGER ========== -->
<div class="modal fade" id="ajouterPassagerModal" tabindex="-1" aria-labelledby="ajouterPassagerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('passage.storePassage') }}">
                @csrf
                <input type="hidden" name="sinistre_id" value="{{ $sinistres->id }}">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="ajouterPassagerModalLabel"><i class="fas fa-user-plus me-2"></i>Ajouter un passager</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" class="form-control" name="nom_passager" placeholder="Entrez le nom">
                    </div>
                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" class="form-control" name="prenom_passager" placeholder="Entrez le prénom">
                    </div>
                    <div class="mb-3">
                        <label>Date de naissance</label>
                        <input type="date" name="date_naissance_passager" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label>Type de passager</label>
                        <select class="form-select" name="type_passager" id="type_passager_select" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="conducteur"
                                {{ $conducteurExiste ? 'disabled' : '' }}>
                                Conducteur
                            </option>
                            <option value="passager">Passager</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
