@extends('templates.navbar2')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            @if (session('status'))
                <div class="alert alert-success">
                     {{ session('status') }}
                </div>
            @endif

            <!-- Alert -->
            <div class="alert alert-info d-flex align-items-center mb-4 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>
                    <strong>Information importante :</strong> Veuillez remplir tous les champs obligatoires marqués d'un astérisque (*).
                </div>
            </div>

            <!-- Card -->
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h2 class="mb-1">
                        <i class="bi bi-clipboard-check me-2"></i> Déclaration de Sinistre Automobile
                    </h2>
                    
                </div>

                <div class="card-body p-4">
                    <form method="POST" class="row g-3 needs-validation" action="{{ route('gestionnaire.store') }}" novalidate>
                        @csrf

                        <!-- Assuré principal -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                            <legend class="float-none w-auto px-3 fw-bold text-primary">Assuré principal</legend>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nom" class="form-label fw-semibold">Nom *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="prenom" class="form-label fw-semibold">Prénom *</label>
                                    <input type="text" class="form-control" id="prenom" name="prenom" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_tel" class="form-label fw-semibold">Téléphone *</label>
                                    <input type="tel" class="form-control" id="num_tel" name="num_tel" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_pol" class="form-label fw-semibold">Numéro de police *</label>
                                    <input type="text" class="form-control" id="num_pol" name="num_pol" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="num_matri" class="form-label fw-semibold">Matricule du véhicule *</label>
                                    <input type="text" class="form-control" id="num_matri" name="num_matri" required>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Sinistre -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                            <legend class="float-none w-auto px-3 fw-bold text-danger">Informations sur le sinistre</legend>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="date_sinistre" class="form-label fw-semibold">Date du sinistre *</label>
                                    <input type="date" class="form-control" id="date_sinistre" name="date_sinistre" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="lieu" class="form-label fw-semibold">Lieu du sinistre *</label>
                                    <input type="text" class="form-control" id="lieu" name="lieu" required>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">Description *</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="type_sinistre" class="form-label fw-semibold">Type de sinistre *</label>
                                    <select class="form-select" id="type_sinistre" name="type_sinistre" required>
                                        <option value="">Choisir...</option>
                                        <option value="collision">Collision avec un autre véhicule</option>
                                        <option value="materiel">Dommages matériels uniquement</option>
                                        <option value="corporel">Dommages corporels</option>
                                        <option value="vol">Vol ou tentative de vol</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Assuré tiers -->
                        <fieldset class="border rounded-3 p-3 mb-4">
                            <legend class="float-none w-auto px-3 fw-bold text-success">Assuré tiers</legend>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="nom_tiers" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom_tiers" name="nom_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="prenom_tiers" class="form-label">Prénom</label>
                                    <input type="text" class="form-control" id="prenom_tiers" name="prenom_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="num_tel_tiers" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="num_tel_tiers" name="num_tel_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="num_pol_tiers" class="form-label">Numéro de police</label>
                                    <input type="text" class="form-control" id="num_pol_tiers" name="num_pol_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="nom_assurance_tiers" class="form-label">Compagnie d’assurance</label>
                                    <input type="text" class="form-control" id="nom_assurance_tiers" name="nom_assurance_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="contact_assurance_tiers" class="form-label">Contact de l'assurance</label>
                                    <input type="text" class="form-control" id="contact_assurance_tiers" name="contact_assurance_tiers">
                                </div>
                                <div class="col-md-4">
                                    <label for="num_matri_tiers" class="form-label">Matricule véhicule</label>
                                    <input type="text" class="form-control" id="num_matri_tiers" name="num_matri_tiers">
                                </div>
                            </div>
                        </fieldset>

                        <!-- Submit -->
                        <div class="col-12 text-center">
                            <button class="btn btn-primary btn-lg px-5 shadow-sm" type="submit">
                                <i class="bi bi-save me-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
