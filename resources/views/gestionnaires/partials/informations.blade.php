<div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-clean mb-4">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Détails du sinistre</h5>
                            <span class="badge bg-primary status-badge">{{ $sinistres->type_sinistre }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Date du sinistre</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <strong>{{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y à H:i') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-muted small mb-1">Lieu du sinistre</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <strong>{{ $sinistres->lieu }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted small mb-1">Description</label>
                                <div class="border rounded p-3 bg-light">
                                    {{ $sinistres->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Galerie photos  -->
            <div class="card card-clean">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galerie photos</h5>
                </div>
                <div class="card-body">
                    @if($sinistres->documents->where('type_doc', 'photos')->count() > 0)
                    <div class="row g-3">
                        @foreach($sinistres->documents->whereIn('type_doc', ['photos']) as $document)
                            @php
                                $imgPath = ($document->path && file_exists(storage_path('app/public/' . $document->path)))
                                            ? asset('storage/' . $document->path)
                                            : asset('image/defaultimage.png');
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-0">
                                    <img src="{{ $imgPath }}" class="card-img-top img-hover-zoom" alt="Photo du sinistre" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center p-2">
                                        <small class="text-muted">{{ $document->nom_fichier }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-camera"></i>
                        <h6>Aucune photo disponible</h6>
                        <p class="text-muted">Aucune photo n'a été uploadée pour ce sinistre.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>