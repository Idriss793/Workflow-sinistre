<!-- ========== MODAL CONSULTER PASSAGER ========== -->
<div class="modal fade" id="consulterPassagerModal" tabindex="-1" aria-labelledby="consulterPassagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i> Détails du passager</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nom :</strong> <span id="consulterNom"></span></p>
                <p><strong>Prénom :</strong> <span id="consulterPrenom"></span></p>
                <p><strong>Date de naissance :</strong> <span id="consulterDate"></span></p>
                <p><strong>Type :</strong> <span id="consulterType"></span></p>

                <hr>
                <h6><i class="fas fa-file-alt me-2"></i> Documents associés</h6>
                <ul class="list-group" id="consulterDocuments">
                    <li class="list-group-item text-muted">Aucun document</li>
                </ul>
            </div>
        </div>
    </div>
</div>
