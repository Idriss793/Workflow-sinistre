@extends('templates.navbar3')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-primary">
                            <i class="fas fa-users me-2"></i>Membres du personnel
                        </h4>
                        <a href="{{ url('register') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Ajouter un employé
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Numéro de téléphone</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateurs as $user)
                                    <tr>

                                        <td class="fw-semibold">{{ $user->name ?? '-' }}</td>
                                        <td>{{ $user->first_name ?? '-' }}</td>

                                        <td>
                                            <span class="d-flex align-items-center">
                                                <i class="fas fa-phone text-muted me-2"></i>
                                                {{ $user->phone_number ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                                <i class="fas fa-circle me-1 small"></i>
                                                {{ $user->is_active ? "Actif" : "Inactif" }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary btn-view" data-id="{{ $user->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-warning btn-edit" data-id="{{ $user->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button class="btn btn-sm btn-toggle {{ $user->is_active ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                data-id="{{ $user->id }}">
                                                <i class="fas {{ $user->is_active ? 'fa-unlock' : 'fa-lock' }}"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de <strong>{{ $utilisateurs->count() }}</strong> employés
                            sur un total de <strong>{{ $utilisateurs->total() }}</strong>
                        </div>
                        <nav>
                            {{ $utilisateurs->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


{{-- ======================= MODAL SHOW ======================= --}}
<div class="modal fade" id="modalShowUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Informations de l'utilisateur</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p><strong>Nom :</strong> <span id="show_name"></span></p>
                <p><strong>Prénom :</strong> <span id="show_first_name"></span></p>
                <p><strong>Email :</strong> <span id="show_email"></span></p>
                <p><strong>Numéro :</strong> <span id="show_phone"></span></p>
                <p><strong>Statut :</strong> <span id="show_status"></span></p>
            </div>

        </div>
    </div>
</div>


{{-- ======================= MODAL EDIT ======================= --}}
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="editUserForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Modifier un utilisateur</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Téléphone</label>
                        <input type="text" name="phone_number" id="edit_phone" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn btn-primary">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>



{{-- ======================= SCRIPT CORRIGÉ ======================= --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    // Voir utilisateur
    document.querySelectorAll('.btn-view').forEach(btn => {
        btn.addEventListener('click', async function () {

            const userId = this.dataset.id;

            const res = await fetch(`/users/${userId}`);
            const user = await res.json();

            document.getElementById('show_name').textContent = user.name;
            document.getElementById('show_first_name').textContent = user.first_name;
            document.getElementById('show_email').textContent = user.email;
            document.getElementById('show_phone').textContent = user.phone_number;
            document.getElementById('show_status').textContent = user.is_active ? "Actif" : "Inactif";

            new bootstrap.Modal(document.getElementById('modalShowUser')).show();
        });
    });


    // Modifier utilisateur
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', async function () {

            const userId = this.dataset.id;

            const res = await fetch(`/users/${userId}`);
            const user = await res.json();

            document.getElementById('editUserForm').action = `/users/${userId}/update`;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_first_name').value = user.first_name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_phone').value = user.phone_number;

            new bootstrap.Modal(document.getElementById('modalEditUser')).show();
        });
    });


    // Activer / Désactiver
    document.querySelectorAll('.btn-toggle').forEach(btn => {
        btn.addEventListener('click', async function () {

            const userId = this.dataset.id;

            const res = await fetch(`/users/${userId}/toggle-active`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                }
            });

            const result = await res.json();
            alert(result.message);
            location.reload();
        });
    });

});
</script>


<style>
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: .875rem;
        letter-spacing: .5px;
        color: #6c757d;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem .75rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, .04);
    }

    .btn-sm {
        padding: .375rem .75rem;
        border-radius: .5rem;
    }

    .badge {
        font-size: .75rem;
        padding: .35em .65em;
    }
</style>

@endsection
