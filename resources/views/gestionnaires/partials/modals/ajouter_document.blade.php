<!-- ========== MODAL JOINDRE DOCUMENT ========== -->
<div class="modal fade" id="ajouterDocumentModal" tabindex="-1" aria-labelledby="ajouterDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="ajouterDocumentModalLabel">
                    <i class="fas fa-paperclip me-2"></i> Joindre un document
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('passage.joindreDocument') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body">
                    <!-- Champ caché : ID du sinistre -->
                    <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? '' }}">
                    <!-- Champ caché : ID du passager (rempli dynamiquement via JS) -->
                    <input type="hidden" name="passage_id">

                    <div class="mb-3">
                        <label for="type_doc" class="form-label fw-semibold">Type de document <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="type_doc" 
                            id="type_doc" 
                            class="form-control" 
                            placeholder="Exemple : Carte d’identité, permis, photo, etc."
                            required>
                        <div class="invalid-feedback">
                            Veuillez indiquer le type de document.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label fw-semibold">Fichier à joindre <span class="text-danger">*</span></label>
                        <input 
                            type="file" 
                            name="document" 
                            id="document" 
                            class="form-control" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            required>
                        <div class="form-text">Formats acceptés : PDF, JPG, PNG — Taille max : 5 Mo</div>
                        <div class="invalid-feedback">
                            Veuillez sélectionner un fichier valide.
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-warning text-white">
                        <i class="fas fa-paperclip me-1"></i> Joindre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
