<div class="tab-pane fade" id="expertise" role="tabpanel">
    <div class="card mt-4 shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-file-signature me-2"></i>Expertises reçues</h5>
        </div>
        <div class="card-body">
            @if($sinistres->expertise->isEmpty())
                <p class="text-muted text-center mb-0">Aucune expertise reçue pour le moment.</p>
            @else
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Date de réception</th>
                            <th>Expert</th>
                            <th>Estimation (FCFA)</th>
                            <th>Document</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($sinistres->expertise as $index => $exp)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $exp->created_at->format('d/m/Y à H:i') }}</td>
                                <td>{{ $exp->expert->name ?? 'Non renseigné' }}</td>
                                <td>{{ number_format($exp->estimation_degats, 0, ',', ' ') }}</td>
                                <td>
                                    @if($exp->expertise_path)
                                        <a href="{{ asset('storage/' . $exp->expertise_path) }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-file-pdf text-danger"></i> Voir
                                        </a>
                                    @else
                                        <span class="text-muted">Aucun fichier</span>
                                    @endif
                                </td>
                                <td>{{ $exp->statut->lib_statut }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>