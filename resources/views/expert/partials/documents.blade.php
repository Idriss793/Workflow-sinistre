<div class="tab-pane fade" id="documents-expert" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <h5><i class="fas fa-clipboard-list text-primary me-2"></i>État des documents requis</h5>
                    <ul class="list-group mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Photos des dégâts
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Constat amiable signé
                            <i class="fas fa-times-circle text-danger document-status-icon" title="Document manquant"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Copie de la carte grise
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Relevé d'informations permis
                            <i class="fas fa-times-circle text-danger document-status-icon" title="Document manquant"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Devis de réparation
                            <i class="fas fa-check-circle text-success document-status-icon" title="Document reçu"></i>
                        </li>
                    </ul>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-download text-primary me-2"></i>Documents téléversés</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Nom</th>
                                            <th>Taille</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sinistres->documents ?? [] as $document)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">{{ $document->type_doc ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $document->nom_fichier ?? 'N/A' }}</td>
                                            <td><small>{{ $document->taille ?? 'N/A' }}</small></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ asset('storage/' . $document->path) }}" target="_blank"
                                                        class="btn btn-outline-info btn-sm" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $document->path) }}" download
                                                        class="btn btn-outline-success btn-sm" title="Télécharger">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Aucun document trouvé</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>