<div class="tab-pane fade" id="assure-tiers" role="tabpanel">
    <div class="container-fluid">

        <!--  Tableau des assurés tiers -->
        <div class="card card-clean mb-4">
            <div class="card-header bg-light text-center fw-bold fs-5">
                <i class="fas fa-user-shield me-2 text-primary"></i>Informations des assurés tiers
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Téléphone</th>
                                <th>Numéro de police</th>
                                <th>Matricule</th>
                                <th>Compagnie</th>
                                <th>Localisation</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($sinistres->assureTiers as $index => $assure_tiers)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $assure_tiers->nom_tiers }}</td>
                                    <td>{{ $assure_tiers->prenom_tiers }}</td>
                                    <td>{{ $assure_tiers->num_tel_tiers }}</td>
                                    <td>{{ $assure_tiers->num_pol_tiers }}</td>
                                    <td>{{ $assure_tiers->num_matri_tiers }}</td>
                                    <td>{{ $assure_tiers->nom_assurance_tiers }}</td>
                                    <td>{{ $assure_tiers->contact_assurance_tiers }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted">Aucun assuré tiers trouvé pour ce sinistre.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--  Tableau des passagers -->
        <div class="card card-clean">
            <div class="card-header bg-light text-center fw-bold fs-5">
                <i class="fas fa-users me-2 text-primary"></i>Liste des passagers liés
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Âge</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($passages as $passager)
                                <tr>
                                    <td>{{ $passager->id }}</td>
                                    <td>{{ $passager->nom_passager }}</td>
                                    <td>{{ $passager->prenom_passager }}</td>
                                    <td>
                                        @if($passager->date_naissance_passager)
                                            {{ \Carbon\Carbon::parse($passager->date_naissance_passager)->age }} ans
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $passager->type_passager === 'conducteur' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($passager->type_passager) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info text-white me-1 view-passager"
                                                data-id="{{ $passager->id }}"
                                                data-nom="{{ $passager->nom_passager }}"
                                                data-prenom="{{ $passager->prenom_passager }}"
                                                data-date="{{ $passager->date_naissance_passager }}"
                                                data-type="{{ $passager->type_passager }}"
                                                data-bs-toggle="tooltip"
                                                title="Voir {{ $passager->nom_passager }} {{ $passager->prenom_passager }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted">Aucun passager trouvé pour ce sinistre.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($passages, 'links'))
                    <div class="d-flex justify-content-end mt-3">
                        {{ $passages->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal d'affichage du passager -->
<div class="modal fade" id="consulterPassagerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user me-2"></i>Détails du passager</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2"><strong>Nom :</strong> <span id="modalNom"></span></div>
                <div class="mb-2"><strong>Prénom :</strong> <span id="modalPrenom"></span></div>
                <div class="mb-2"><strong>Date de naissance :</strong> <span id="modalDate"></span></div>
                <div class="mb-2"><strong>Type :</strong> <span id="modalType" class="badge bg-secondary"></span></div>

                <hr>

                <h6>Documents liés :</h6>
                <ul id="modalDocuments" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>



<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el);
    });

    // Gestion du clic sur le bouton "voir"
    document.querySelectorAll('.view-passager').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nomField = document.getElementById('modalNom');
            const prenomField = document.getElementById('modalPrenom');
            const dateField = document.getElementById('modalDate');
            const typeField = document.getElementById('modalType');
            const documentsList = document.getElementById('modalDocuments');

            // Affiche immédiatement les infos de base
            nomField.textContent = this.dataset.nom || '-';
            prenomField.textContent = this.dataset.prenom || '-';
            dateField.textContent = this.dataset.date 
                ? new Date(this.dataset.date).toLocaleDateString('fr-FR') 
                : '-';
            typeField.textContent = this.dataset.type || '-';
            typeField.className = 'badge ' + (this.dataset.type === 'conducteur' ? 'bg-success' : 'bg-secondary');

            // Appel à ta fonction show() via fetch pour récupérer les documents
            fetch(`/passages/${id}`)
                .then(res => res.json())
                .then(data => {
                    const documents = data.documents;

                    if (documents.length > 0) {
                        documentsList.innerHTML = '';
                        documents.forEach(doc => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center';
                            li.innerHTML = `
                                <span>${doc.type_doc ?? 'Document'}</span>
                                <a href="/storage/${doc.path}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download me-1"></i>Télécharger
                                </a>
                            `;
                            documentsList.appendChild(li);
                        });
                    } else {
                        documentsList.innerHTML = '<li class="list-group-item text-muted">Aucun document disponible.</li>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    nomField.textContent = 'Erreur de chargement';
                    documentsList.innerHTML = '<li class="list-group-item text-danger">Impossible de charger les informations.</li>';
                });

            // Afficher le modal
            const modal = new bootstrap.Modal(document.getElementById('consulterPassagerModal'));
            modal.show();
        });
    });
});
</script>
