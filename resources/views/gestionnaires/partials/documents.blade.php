<div class="tab-pane fade" id="documents" role="tabpanel">
    <div class="row g-4">

        <!-- Liste des documents -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-folder-open me-2"></i>Documents téléversés</h5>
                    <span class="badge bg-light text-primary">{{ $sinistres->documents->count() }} fichier(s)</span>
                </div>

                <div class="card-body">
                    @if ($sinistres->documents && $sinistres->documents->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Nom du fichier</th>
                                        <th>Taille</th>
                                        <th>Date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sinistres->documents as $document)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary text-white">
                                                    <i class="fas fa-{{ $documentTypes[$document->type_doc]['icon'] ?? 'file' }} me-1"></i>
                                                    {{ ucfirst($document->type_doc) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas
                                                        @if(str_contains($document->nom_fichier, '.pdf')) fa-file-pdf text-danger
                                                        @elseif(str_contains($document->nom_fichier, '.doc')) fa-file-word text-primary
                                                        @elseif(str_contains($document->nom_fichier, '.xls')) fa-file-excel text-success
                                                        @elseif(str_contains($document->nom_fichier, '.jpg') || str_contains($document->nom_fichier, '.png')) fa-file-image text-warning
                                                        @else fa-file text-muted
                                                        @endif me-2">
                                                    </i>
                                                    {{ $document->nom_fichier }}
                                                </div>
                                            </td>
                                            <td>{{ $document->taille }}</td>
                                            <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank" class="btn btn-outline-primary" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $document->path) }}" download class="btn btn-outline-success" title="Télécharger">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h6>Aucun document disponible</h6>
                            <p class="text-muted small">Aucun document n’a encore été uploadé pour ce sinistre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formulaire d'upload -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Ajouter un document</h5>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{ route('document.store') }}" id="uploadForm">
                        @csrf
                        <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? old('sinistre_id') }}">

                        <div class="upload-area mb-3 p-4 border border-primary rounded text-center" 
                             onclick="document.getElementById('documentUpload').click();" 
                             style="cursor: pointer; background-color: rgba(0, 123, 255, 0.05);">
                            <i class="fas fa-upload fa-2x text-primary mb-2"></i>
                            <p class="fw-semibold mb-1">Cliquez pour sélectionner un fichier</p>
                            <small class="text-muted d-block">Formats acceptés : PDF, JPG, PNG, DOC...</small>
                            <input type="file" class="d-none" id="documentUpload" name="path" onchange="previewFileName(event)">
                            <div id="filePreview" class="mt-3 text-primary fw-bold"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type de document</label>
                            <select class="form-select" name="type_doc" required>
                                <option value="" disabled selected>Sélectionner un type...</option>
                                <option value="constat">Constat amiable</option>
                                <option value="photos">Photos</option>
                                <option value="permis">Relevé permis</option>
                                <option value="carte_grise">Carte grise</option>
                                <option value="devis">Devis</option>
                                <option value="contrat">Contrat assuré</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nom du document</label>
                            <input type="text" class="form-control" name="nom_fichier" placeholder="Ex: Constat amiable signé">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-2"></i>Uploader le document
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewFileName(event) {
    const input = event.target;
    const preview = document.getElementById('filePreview');

    if (input.files && input.files.length > 0) {
        let file = input.files[0];
        preview.innerHTML = `<i class="fas fa-file me-1"></i> ${file.name}`;

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML += `
                    <div class="mt-2">
                        <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-height: 120px;">
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    } else {
        preview.innerHTML = "";
    }
}
</script>
