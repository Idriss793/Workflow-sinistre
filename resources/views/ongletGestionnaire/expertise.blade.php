<!-- Expertise -->
 
<div class="tab-pane fade" id="expertise" role="tabpanel">
    <div class="expertise-section">
        <!-- En-tête avec statistiques -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h5><i class="fas fa-tools text-primary me-2"></i>Rapports d'expertise automobile</h5>
                <p class="text-muted mb-0">Analyse détaillée des expertises réalisées sur ce sinistre</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print()">
                        <i class="fas fa-print me-1"></i>Imprimer
                    </button>
                    <a href="#" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-file-pdf me-1"></i>PDF
                    </a>
                </div>
            </div>
        </div>

        @if($sinistres->expertise->isEmpty())
            <!-- État vide amélioré -->
            <div class="card card-clean">
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune expertise disponible</h5>
                        <p class="text-muted mb-4">Aucun rapport d'expertise n'a été soumis pour ce sinistre.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-sync me-1"></i>Actualiser
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Demander une expertise
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Cartes de résumé des expertises -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Expertises</h6>
                                    <h3 class="text-white mb-0">{{ $sinistres->expertise->count() }}</h3>
                                </div>
                                <i class="fas fa-file-alt fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-clean h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Véhicules réparables</h6>
                                    <h4 class="text-success mb-0">
                                        {{ $sinistres->expertise->where('reparable', true)->count() }}
                                    </h4>
                                </div>
                                <i class="fas fa-wrench text-success fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-clean h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Expertises complémentaires</h6>
                                    <h4 class="text-warning mb-0">
                                        {{ $sinistres->expertise->where('expertise_complementaire', true)->count() }}
                                    </h4>
                                </div>
                                <i class="fas fa-search-plus text-warning fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-clean h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Coût total estimé</h6>
                                    <h4 class="text-info mb-0">
                                        {{ number_format($sinistres->expertise->sum('estimation_degats'), 0, ',', ' ') }} FCFA
                                    </h4>
                                </div>
                                <i class="fas fa-calculator text-info fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des expertises sous forme de cartes détaillées -->
            <div class="row g-4">
                @foreach($sinistres->expertise as $index => $exp)
                <div class="col-12">
                    <div class="card card-clean expertise-card">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon" style="width: 45px; height: 45px;">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Rapport d'expertise #{{ $index + 1 }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $exp->created_at->translatedFormat('d F Y à H:i') }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                @if($exp->expertise_path)
                                <a href="{{ asset('storage/'.$exp->expertise_path) }}" 
                                   class="btn btn-outline-primary btn-sm" 
                                   target="_blank"
                                   data-bs-toggle="tooltip" 
                                   title="Voir le document">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset('storage/'.$exp->expertise_path) }}" 
                                   download
                                   class="btn btn-outline-success btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row g-4">
                                <!-- État général et estimation -->
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">État général</small>
                                        <span class="badge 
                                            @if($exp->etat_general == 'excellent') bg-success
                                            @elseif($exp->etat_general == 'bon') bg-info
                                            @elseif($exp->etat_general == 'moyen') bg-warning
                                            @elseif($exp->etat_general == 'mauvais') bg-danger
                                            @else bg-secondary
                                            @endif status-badge">
                                            {{ $exp->etat_general ?? 'Non spécifié' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Estimation des dégâts</small>
                                        <h5 class="text-primary mb-0">
                                            {{ number_format($exp->estimation_degats ?? 0, 0, ',', ' ') }} FCFA
                                        </h5>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Véhicule réparable</small>
                                        @if($exp->reparable)
                                            <span class="badge bg-success status-badge">
                                                <i class="fas fa-check me-1"></i>Réparable
                                            </span>
                                        @else
                                            <span class="badge bg-danger status-badge">
                                                <i class="fas fa-times me-1"></i>Non réparable
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <small class="text-muted d-block mb-2">Expertise complémentaire</small>
                                        @if($exp->expertise_complementaire)
                                            <span class="badge bg-warning text-dark status-badge">
                                                <i class="fas fa-exclamation-triangle me-1"></i>Requis
                                            </span>
                                        @else
                                            <span class="badge bg-secondary status-badge">
                                                <i class="fas fa-check me-1"></i>Non requis
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Analyse des dommages -->
                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="fas fa-search me-2 text-primary"></i>
                                            Analyse des dommages
                                        </h6>
                                        <div class="analysis-content">
                                            @if($exp->analyse_dommages)
                                                <p class="mb-0">{{ $exp->analyse_dommages }}</p>
                                            @else
                                                <p class="text-muted mb-0 fst-italic">Aucune analyse fournie</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Recommandations -->
                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <h6 class="d-flex align-items-center mb-3">
                                            <i class="fas fa-lightbulb me-2 text-warning"></i>
                                            Recommandations
                                        </h6>
                                        <div class="recommendations-content">
                                            @if($exp->recommandations)
                                                <p class="mb-0">{{ $exp->recommandations }}</p>
                                            @else
                                                <p class="text-muted mb-0 fst-italic">Aucune recommandation fournie</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Métadonnées -->
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <small class="text-muted">
                                            <i class="fas fa-id-badge me-1"></i>
                                            ID Expertise: #{{ $exp->id }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Mise à jour: {{ $exp->updated_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Résumé global -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-clean">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>
                                Synthèse des expertises
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h4 class="text-primary">{{ $sinistres->expertise->count() }}</h4>
                                        <small class="text-muted">Total expertises</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h4 class="text-success">{{ $sinistres->expertise->where('reparable', true)->count() }}</h4>
                                        <small class="text-muted">Véhicules réparables</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border-end">
                                        <h4 class="text-warning">{{ $sinistres->expertise->where('expertise_complementaire', true)->count() }}</h4>
                                        <small class="text-muted">Expertises complémentaires</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div>
                                        <h4 class="text-info">{{ number_format($sinistres->expertise->avg('estimation_degats'), 0, ',', ' ') }} FCFA</h4>
                                        <small class="text-muted">Coût moyen par expertise</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.expertise-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.expertise-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.analysis-content, .recommendations-content {
    max-height: 120px;
    overflow-y: auto;
    padding-right: 10px;
}

.analysis-content::-webkit-scrollbar,
.recommendations-content::-webkit-scrollbar {
    width: 4px;
}

.analysis-content::-webkit-scrollbar-track,
.recommendations-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 2px;
}

.analysis-content::-webkit-scrollbar-thumb,
.recommendations-content::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 2px;
}

.analysis-content::-webkit-scrollbar-thumb:hover,
.recommendations-content::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.status-badge {
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 20px;
}

@media (max-width: 768px) {
    .expertise-card .card-body .row > div {
        margin-bottom: 1rem;
    }
    
    .analysis-content, .recommendations-content {
        max-height: none;
    }
}
</style>

<script>
// Initialiser les tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>