<div class="tab-pane fade" id="parties" role="tabpanel">
            <div class="row g-4">
                
                <!-- Assuré principal -->
                <div class="col-lg-6">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Assuré principal</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($sinistres->assurePrincipals ?? [] as $assure)
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Nom</small><br>
                                        <strong>{{ $assure->nom ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Prénom</small><br>
                                        <strong>{{ $assure->prenom ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Téléphone</small><br>
                                        <a href="tel:{{ $assure->num_tel ?? '' }}" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-1"></i>{{ $assure->num_tel ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Police N°</small><br>
                                        <code>{{ $assure->num_pol ?? 'N/A' }}</code>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Matricule véhicule</small><br>
                                        <span class="badge bg-dark">{{ $assure->num_matri ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Aucun assuré principal trouvé</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Assuré tiers -->
                <div class="col-lg-6">
                    @forelse ($sinistres->assureTiers ?? [] as $assure_tiers)
                        <div class="card h-100 border-warning mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="fas fa-user-alt me-2"></i>Partie adverse</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Nom</small><br>
                                        <strong>{{ $assure_tiers->nom_tiers ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Prénom</small><br>
                                        <strong>{{ $assure_tiers->prenom_tiers ?? 'N/A' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Téléphone</small><br>
                                        <a href="tel:{{ $assure_tiers->num_tel_tiers ?? '' }}" class="text-decoration-none">
                                            <i class="fas fa-phone text-success me-1"></i>{{ $assure_tiers->num_tel_tiers ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Police N°</small><br>
                                        <code>{{ $assure_tiers->num_pol_tiers ?? 'N/A' }}</code>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">Matricule</small><br>
                                        <span class="badge bg-dark">{{ $assure_tiers->num_matri_tiers ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-building me-2"></i>Compagnie d'assurance tiers</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>Compagnie :</strong> {{ $assure_tiers->nom_assurance_tiers ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Contact :</strong> {{ $assure_tiers->contact_assurance_tiers ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="card h-100 border-warning mb-3">
                            <div class="card-body text-center">
                                <p class="text-muted">Aucune partie adverse trouvée</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>