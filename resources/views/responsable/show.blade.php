@extends('templates.navbar3')
@section('content')
<style>
    .img-hover-zoom {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .img-hover-zoom:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
</style>


<div class="container-fluid my-4">
    
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Consultation du sinistre #{{$sinistres->numero_sinistre}}</h2>
        <span class="badge bg-warning fs-6">{{ $sinistres->statut->lib_statut}}</span>
    </div>

    

    <!-- <div class="alert alert-danger d-flex align-items-start">
        <i class="fas fa-exclamation-triangle fa-lg me-2 mt-1"></i>
        <div>
            <h5 class="alert-heading">Documents manquants</h5>
            <p class="mb-1">Veuillez fournir les documents suivants pour finaliser le traitement :</p>
            <ul class="mb-0">
               
                <li>Constat amiable d'accident signé</li>
                <li>Photos des dégâts complets du véhicule</li>
                <li>Relevé d'informations du permis de conduire</li>
            </ul>
        </div>
    </div> -->

    <!-- Onglets Bootstrap -->
    <ul class="nav nav-tabs" id="sinistreTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                Infos Sinistre & Expertises
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-principal-tab" data-bs-toggle="tab" data-bs-target="#assure-principal" type="button" role="tab">
                Assuré principal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-tiers-tab" data-bs-toggle="tab" data-bs-target="#assure-tiers" type="button" role="tab">
               Partie impliqué
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                Documents
            </button>
        </li>
       
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="sinistreTabsContent">
        <!-- Infos Sinistre -->
        @include('responsable.partials.infos_sinistre')

        <!-- Assuré principal -->
        
        @include('responsable.partials.assure_principal')

        <!-- Assuré tiers -->
        @include('responsable.partials.assure_tiers')

        <!-- Documents -->
        @include('responsable.partials.documents')

     



    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Active les tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    // Gestion du dernier onglet ouvert (persistance)
    const tabKey = 'activeSinistreTab';
    const storedTab = localStorage.getItem(tabKey);

    
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Validation d'une expertise
    document.querySelectorAll('.btn-valider').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Confirmer la validation',
                text: "Voulez-vous vraiment valider cette expertise ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Oui, valider',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#198754',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/expertises/${id}/valider`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Expertise validée',
                                text: 'Cette expertise a été validée avec succès.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            button.disabled = true;
                            button.nextElementSibling.disabled = true;
                            setTimeout(() => location.reload(), 2000);
                        }
                    });
                }
            });
        });
    });

    // Refus d'une expertise
    document.querySelectorAll('.btn-refuser').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Refuser cette expertise',
                input: 'textarea',
                inputLabel: 'Veuillez indiquer le motif du refus :',
                inputPlaceholder: 'Écrire ici...',
                inputAttributes: { 'aria-label': 'Motif du refus' },
                showCancelButton: true,
                confirmButtonText: 'Confirmer le refus',
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#d33',
                preConfirm: (motif) => {
                    if (!motif) {
                        Swal.showValidationMessage('Le motif du refus est obligatoire');
                        return false;
                    }
                    return motif;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/expertises/${id}/refuser`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ motif: result.value })
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Expertise refusée',
                                text: 'Le refus a été enregistré avec succès.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            button.disabled = true;
                            button.previousElementSibling.disabled = true;
                            setTimeout(() => location.reload(), 2000);
                        }
                    });
                }
            });
        });
    });
});
</script>
@endpush

