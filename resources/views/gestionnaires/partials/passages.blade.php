
<div class="tab-pane fade" id="passage" role="tabpanel" aria-labelledby="passage-tab">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-users me-2"></i>Liste des passagers</h4>
                        <button class="btn btn-light btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#ajouterPassagerModal"
                            data-bs-toggle="tooltip"
                            title="Ajouter un passager">
                            <i class="fas fa-user-plus"></i>
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Âge</th>
                                    <th>Type passager</th>
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
                                        <span class="badge {{ $passager->type_passager == 'conducteur' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($passager->type_passager) }}
                                        </span>
                                    </td>
                                    <td>
                                      
                                        <button class="btn btn-sm btn-warning btn-edit-passager me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modifierPassagerModal"
                                                data-id="{{ $passager->id }}"
                                                data-nom="{{ $passager->nom_passager }}"
                                                data-prenom="{{ $passager->prenom_passager }}"
                                                data-date="{{ $passager->date_naissance_passager }}"
                                                data-type="{{ $passager->type_passager }}"
                                                data-bs-toggle="tooltip"
                                                title="Modifier ce passager">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    
                                        <button class="btn btn-sm btn-info text-white me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#consulterPassagerModal"
                                                data-id="{{ $passager->id }}"
                                                data-nom="{{ $passager->nom_passager }}"
                                                data-prenom="{{ $passager->prenom_passager }}"
                                                data-date="{{ $passager->date_naissance_passager }}"
                                                data-type="{{ $passager->type_passager }}"
                                                data-bs-toggle="tooltip"
                                                title="Consulter les informations">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                    
                                        <button class="btn btn-sm btn-warning text-white"
                                                data-bs-toggle="modal"
                                                data-bs-target="#ajouterDocumentModal"
                                                data-id="{{ $passager->id }}"
                                                data-bs-toggle="tooltip" 
                                                title="Joindre un document">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Aucun passager trouvé.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {{ $passages->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL AJOUTER PASSAGER -->
@include('gestionnaires.partials.modals.ajouter_passager')

<!-- MODAL CONSULTER PASSAGER -->
@include('gestionnaires.partials.modals.consulter_passager')

<!-- MODAL MODIFIER PASSAGER -->
@include('gestionnaires.partials.modals.modifier_passager')

<!-- MODAL JOINDRE DOCUMENT -->
@include('gestionnaires.partials.modals.ajouter_document')







