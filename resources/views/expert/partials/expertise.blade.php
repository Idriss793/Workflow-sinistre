<div class="tab-pane fade" id="expertise" role="tabpanel">
    <div class="container mt-4">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-car-crash me-2"></i>Soumettre un rapport d'expertise
                </h5>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('expert.storeExpertise') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- ID du sinistre -->
                    <input type="hidden" name="sinistre_id" value="{{ $sinistres->id ?? '' }}">

                    <!-- Estimation -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-money-bill-wave me-1 text-primary"></i>Estimation des dégâts (en FCFA)
                        </label>
                        <div class="input-group">
                            <input type="number" name="estimation_degats" class="form-control" placeholder="Ex : 1500000" step="0.01" required>
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    <!-- Fichier expertise -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-file-upload me-1 text-primary"></i>Joindre le rapport d'expertise (PDF)
                        </label>
                        <input type="file" name="expertise_path" accept=".pdf" class="form-control" required>
                        <div class="form-text text-muted">Formats acceptés : PDF uniquement</div>
                    </div>

                    <!-- Bouton d’envoi -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer le rapport
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>