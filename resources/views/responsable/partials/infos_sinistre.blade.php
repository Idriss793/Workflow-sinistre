<div class="tab-pane fade show active" id="info" role="tabpanel">

    <!-- Informations sur le sinistre -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i> Informations sur le sinistre</h5>
            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                {{ ucfirst($sinistres->statut->lib_statut) }}
            </span>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <strong><i class="bi bi-calendar-event me-1"></i> Date du sinistre :</strong><br>
                    {{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y') }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong><i class="bi bi-geo-alt me-1"></i> Lieu du sinistre :</strong><br>
                    {{ $sinistres->lieu }}
                </div>
            </div>

            <div class="mb-3">
                <strong><i class="bi bi-file-earmark-text me-1"></i> Description :</strong><br>
                <p class="text-muted mb-0">{{ $sinistres->description }}</p>
            </div>

            <div>
                <strong><i class="bi bi-car-front me-1"></i> Type de sinistre :</strong>
                <span class="badge bg-secondary ms-2">{{ $sinistres->type_sinistre }}</span>
            </div>
        </div>
    </div>

    <!-- Photos du sinistre -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-camera me-2"></i> Photos du sinistre</h5>
        </div>
        <div class="card-body">
            @if ($sinistres->documents->whereIn('type_doc', ['photos'])->count() > 0)
                <div class="row">
                    @foreach($sinistres->documents->whereIn('type_doc', ['photos']) as $document)
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 shadow-sm">
                                <img src="{{ asset('storage/' . $document->path) }}" 
                                     class="card-img-top img-hover-zoom rounded" 
                                     alt="Photo du sinistre">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted mb-0">Aucune photo disponible pour ce sinistre.</p>
            @endif
        </div>
    </div>

    <!-- Liste des expertises -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i> Liste des expertises reçues</h5>
            <small class="text-white-50">({{ $expertises->total() }} au total)</small>
        </div>

        <div class="card-body">
            @if ($expertises->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Expert</th>
                                <th>Date de réception</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expertises as $expertise)
                                <tr>
                                    <td>{{ $expertise->expert->name ?? 'N/A' }}</td>
                                    <td>{{ $expertise->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">{{ $expertise->estimation_degats ?? '-' }}</td>
                                    <td>
                                        <span class="badge
                                            @if($expertise->statut->ordre_statut == 5) bg-success
                                            @elseif($expertise->statut->ordre_statut == 4) bg-danger
                                            @else bg-secondary @endif px-3 py-2">
                                            {{ ucfirst($expertise->statut->lib_statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($expertise->statut->ordre_statut != 5 && $expertise->statut->ordre_statut != 4)
                                            <button type="button"
                                                class="btn btn-sm btn-success btn-valider"
                                                data-id="{{ $expertise->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Valider cette expertise">
                                                <i class="bi bi-check-circle"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-sm btn-danger btn-refuser"
                                                data-id="{{ $expertise->id }}"
                                                data-bs-toggle="tooltip"
                                                title="Refuser cette expertise">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-success disabled">
                                                <i class="bi bi-check-circle"></i>
                                                {{ ucfirst($expertise->statut->lib_statut) }}
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $expertises->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-muted text-center mb-0">Aucune expertise reçue pour ce sinistre.</p>
            @endif
        </div>
    </div>

</div>
