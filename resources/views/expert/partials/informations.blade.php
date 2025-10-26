<div class="tab-pane fade show active" id="details" role="tabpanel">
    <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Informations du sinistre</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong><i class="fas fa-hashtag text-muted me-2"></i>Numéro :</strong><br>
                            <span class="fs-5 text-primary">{{ $sinistres->numero_sinistre ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-tag text-muted me-2"></i>Type :</strong><br>
                            <span class="badge bg-secondary">{{ $sinistres->type_sinistre ?? 'Type inconnu' }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-traffic-light text-muted me-2"></i>Statut :</strong><br>
                            <span class="badge bg-primary">{{ $sinistres->statut->lib_statut ?? 'Statut inconnu' }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <strong><i class="fas fa-align-left text-muted me-2"></i>Description complète :</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            {{ $sinistres->description ?? 'Aucune description disponible' }}
                        </div>
                    </div>
                </div>
    </div>
</div>