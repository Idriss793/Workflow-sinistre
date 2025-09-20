@extends('layouts.app')
@section('content')

        
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                 @endif
                
                <div class="d-flex justify-content-center mb-4">
                    <div class="progress-step active">
                        <span>Informations générales</span>
                    </div>
                </div>

                <!-- Alert -->
                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <div>
                        <strong>Information importante :</strong> Veuillez remplir tous les champs obligatoires marqués d'un astérisque (*). Vos données sont sécurisées et traitées conformément à nos politiques de confidentialité.
                    </div>
                </div>

                <!-- Main form card -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary-gradient text-white text-center py-4">
                        <h2 class="mb-2">
                            <i class="bi bi-clipboard-check me-2"></i>Déclaration de Sinistre Automobile
                        </h2>
                        <p class="mb-0">Complétez ce formulaire pour déclarer votre sinistre</p>
                    </div>
                        
                        <div class="card-body p-4">
                            <form class="needs-validation" method="POST"  action="{{ route('gestionnaire.store') }}" novalidate >
                                @csrf
                                <!-- Assuré principal -->
                                <div class="mb-4">
                                    <h4 class="text-primary mb-3 pb-2 section-divider">
                                        <i class="bi bi-person me-2"></i>Assuré Principal
                                    </h4>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="nom" class="form-label fw-semibold required">Nom</label>
                                            <input type="text" class="form-control" id="nom" name="nom" required>
                                            <div class="invalid-feedback">
                                                Veuillez saisir votre nom.
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="prenom" class="form-label fw-semibold required">Prénom</label>
                                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                                            <div class="invalid-feedback">
                                                Veuillez saisir votre prénom.
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="num_tel" class="form-label fw-semibold required">Numéro de téléphone</label>
                                            <input type="tel" class="form-control" id="num_tel" name="num_tel"
                                                   pattern="[0-9+\-\s]+" required>
                                            <div class="invalid-feedback">
                                                Veuillez saisir un numéro de téléphone valide.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="num_pol" class="form-label fw-semibold required">Numéro de police</label>
                                            <input type="text" class="form-control" id="num_pol" name="num_pol" required>
                                            <div class="invalid-feedback">
                                                Veuillez saisir votre numéro de police.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="num_matri" class="form-label fw-semibold required">Immatriculation du véhicule</label>
                                            <input type="text" class="form-control text-uppercase" id="num_matri" name="num_matri" required>
                                            <div class="invalid-feedback">
                                                Veuillez saisir le numéro d'immatriculation.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Information sur le sinistre -->
                                <div class="mb-4">
                                    <h4 class="text-primary mb-3 pb-2 section-divider">
                                        <i class="bi bi-exclamation-triangle me-2"></i>Informations sur le Sinistre
                                    </h4>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="date_sinistre" class="form-label fw-semibold required">Date du sinistre</label>
                                            <input type="date" class="form-control" id="date_sinistre" name="date_sinistre" required>
                                            <div class="invalid-feedback">
                                                Veuillez sélectionner la date du sinistre.
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <label for="heure_sinistre" class="form-label fw-semibold">Heure du sinistre</label>
                                            <input type="time" class="form-control" id="heure_sinistre" name="heure_sinistre">
                                        </div> -->
                                        <div class="col-12">
                                            <label for="lieu" class="form-label fw-semibold required">Lieu du sinistre</label>
                                            <input type="text" class="form-control" id="lieu" name="lieu"
                                                   placeholder="Adresse complète du lieu de l'accident" required>
                                            <div class="invalid-feedback">
                                                Veuillez indiquer le lieu du sinistre.
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="type_sinistre" class="form-label fw-semibold required">Type de sinistre</label>
                                            <select class="form-select" id="type_sinistre" name="type_sinistre" required>
                                                <option value="">Choisir le type de sinistre...</option>
                                                <option value="collision">Collision avec un autre véhicule</option>
                                                <option value="materiel">Dommages matériels uniquement</option>
                                                <option value="corporel">Dommages corporels</option>
                                                <option value="vol">Vol ou tentative de vol</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Veuillez sélectionner le type de sinistre.
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <label for="gravite" class="form-label fw-semibold">Gravité estimée</label>
                                            <select class="form-select" id="gravite" name="gravite">
                                                <option value="">Évaluer la gravité...</option>
                                                <option value="leger">Léger (dégâts mineurs)</option>
                                                <option value="moyen">Moyen (réparations nécessaires)</option>
                                                <option value="grave">Grave (véhicule immobilisé)</option>
                                                <option value="total">Destruction totale</option>
                                            </select>
                                        </div> -->
                                        <div class="col-12">
                                            <label for="description" class="form-label fw-semibold required">Description détaillée des circonstances</label>
                                            <textarea class="form-control" id="description" name="description" rows="4"
                                                      placeholder="Décrivez précisément les circonstances de l'accident, les conditions météorologiques, l'état de la route, etc." required></textarea>
                                            <div class="invalid-feedback">
                                                Veuillez décrire les circonstances du sinistre.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tiers impliqué -->
                                <div class="mb-4">
                                    <h4 class="text-primary mb-3 pb-2 section-divider">
                                        <i class="bi bi-people me-2"></i>Tiers Impliqué (si applicable)
                                    </h4>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="has_third_party" name="has_third_party" onchange="toggleThirdPartyFields()">
                                            <label class="form-check-label fw-semibold" for="has_third_party">
                                                Un tiers est impliqué dans ce sinistre
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div id="third_party_section" class="d-none">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="nom_tiers" class="form-label fw-semibold">Nom du tiers</label>
                                                <input type="text" class="form-control" id="nom_tiers" name="nom_tiers">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="prenom_tiers" class="form-label fw-semibold">Prénom du tiers</label>
                                                <input type="text" class="form-control" id="prenom_tiers" name="prenom_tiers">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="num_tel_tiers" class="form-label fw-semibold">Téléphone du tiers</label>
                                                <input type="tel" class="form-control" id="num_tel_tiers" name="num_tel_tiers">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="num_matri_tiers" class="form-label fw-semibold">Immatriculation du véhicule tiers</label>
                                                <input type="text" class="form-control text-uppercase" id="num_matri_tiers" name="num_matri_tiers">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="num_pol_tiers" class="form-label fw-semibold">Numéro de police du tiers</label>
                                                <input type="text" class="form-control" id="num_pol_tiers" name="num_pol_tiers">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nom_assurance_tiers" class="form-label fw-semibold">Compagnie d'assurance du tiers</label>
                                                <input type="text" class="form-control" id="nom_assurance_tiers" name="nom_assurance_tiers">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="contact_assurance_tiers" class="form-label fw-semibold">Contact assurance tiers</label>
                                                <input type="tel" class="form-control" id="contact_assurance_tiers" name="contact_assurance_tiers">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Documents -->
                                <!-- <div class="mb-4">
                                    <h4 class="text-primary mb-3 pb-2 section-divider">
                                        <i class="bi bi-paperclip me-2"></i>Documents et Photos
                                    </h4>
                                    
                                    <div class="file-upload-area rounded p-4 text-center">
                                        <i class="bi bi-cloud-upload text-secondary" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3">Joindre des documents</h5>
                                        <p class="text-muted">Photos du sinistre, constat amiable, permis de conduire, etc.</p>
                                        <input type="file" class="form-control" id="documents" name="documents[]" multiple accept="image/*,.pdf,.doc,.docx">
                                    </div>
                                </div> -->

                                <!-- Actions -->
                                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end">
                                    <!-- <button type="button" class="btn btn-outline-secondary">
                                        <i class="bi bi-save me-2"></i>Sauvegarder en brouillon
                                    </button> -->
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Envoyer la déclaration
                                    </button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection