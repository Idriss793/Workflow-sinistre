  <div class="tab-pane fade" id="devis" role="tabpanel">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card card-clean">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Liste des devis</h5>
                            <span class="badge bg-primary status-badge">1 devis</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-clean">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Montant</th>
                                            <th>Date</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                                                    <span>Réparation véhicule</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">200 000 FCFA</span>
                                            </td>
                                            <td>28/09/2025</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-clean">
                        <div class="card-header bg-transparent">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Nouveau devis</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="#">
                                @csrf
                                <input type="hidden" name="sinistre_id" value="{{ $sinistres->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control" placeholder="Ex: Réparation carrosserie avant" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Montant</label>
                                    <div class="input-group">
                                        <input type="number" name="montant" class="form-control" placeholder="0.00" step="0.01" required>
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 action-btn">
                                    <i class="fas fa-save me-2"></i>Enregistrer le devis
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>