<div class="tab-pane fade" id="photos" role="tabpanel">
            <h5><i class="fas fa-camera text-primary me-2"></i>Galerie photos du sinistre</h5>
            <p class="text-muted mb-4">Cliquez sur une image pour l'agrandir</p>
            
            <div class="row photo-gallery">
                @forelse(($sinistres->documents ?? collect())->whereIn('type_doc', ['photos']) as $document)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{ asset('storage/' . $document->path) }}" 
                                 class="card-img-top img-hover-zoom"
                                 alt="Photo sinistre"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal"
                                 data-src="{{ asset('storage/' . $document->path) }}">
                            <div class="card-body p-2">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucune photo n'a été téléchargée pour ce sinistre.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
