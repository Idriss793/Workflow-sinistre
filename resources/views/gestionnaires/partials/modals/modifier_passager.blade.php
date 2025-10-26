<!-- ========== MODAL MODIFIER PASSAGER ========== -->
<div class="modal fade" id="modifierPassagerModal" tabindex="-1" aria-labelledby="modifierPassagerModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formModifierPassager" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modifierPassagerModal">
                        <i class="fas fa-edit me-2"></i>Modifier un passager
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- ID caché du passager -->
                    <input type="hidden" id="edit_id_passager" name="id">

                    <div class="mb-3">
                        <label for="edit_nom_passager" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="edit_nom_passager" name="nom_passager" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_prenom_passager" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="edit_prenom_passager" name="prenom_passager" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_date_naissance_passager" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="edit_date_naissance_passager" name="date_naissance_passager">
                    </div>

                    <div class="mb-3">
                        <label for="edit_type_passager" class="form-label">Type de passager</label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
