@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-11">
            
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
            <div class="card-header bg-primary-gradient text-white text-center py-4">
                <h2 class="mb-2">
                    <i class="bi bi-clipboard-check me-2"></i>Déclaration de Sinistre Automobile
                </h2>
                <p class="mb-0">Complétez ce formulaire pour déclarer votre sinistre</p>
            </div>
             
            <form  method="POST" class="row g-3 needs-validation" action="{{ route ('gestionnaire.store') }}" novalidate>
                @csrf
                <p class="fw-bold">Assuré principal</p>
                <div class="col-md-4">
                    <label for="num_tel" class="form-label require">Nom</label>
                    <input type="text" class="form-control" id="nom" value="" name= "nom" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="prenom" class="form-labe requirel">Prenom</label>
                    <input type="text" class="form-control" id="prenom" value="" name="prenom" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_tel" class="form-label require">Numéro de téléphone</label>
                    <input type="tel" class="form-control" id="num_tel" value="" name="num_tel" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_pol" class="form-label require">Numéro de police</label>
                    <input type="tel" class="form-control" id="num_pol" value="" name="num_pol" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_matri" class="form-label require">Numéro de matricule de la voiture</label>
                    <input type="text" class="form-control" id="num_matri" value="" name="num_matri" required>
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <p class="fw-bold">Information sur le sinistre</p>
                <div class="mb-3">
                    <label for="date_sinistre" class="form-label require">Date du sinistre</label>
                    <input type="date" class="form-control" id="date_sinistre" name="date_sinistre" require>
                </div>
                <div class="mb-3">
                    <label for="Lieu" class="form-label require">Lieu du sinistre</label>
                    <input type="text" class="form-control" id="lieu" name="lieu" require>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label require">Description</label>
                    <textarea class="form-control" id="description" name="description" require></textarea>
                </div>
                <div class="mb-3">
                    <label for="type_sinistre" class="form-label require">Type de sinistre</label>
                    <select class="form-select" id="type_sinistre" name="type_sinistre" require>
                        <option value="">Choisir le type de sinistre...</option>
                        <option value="collision">Collision avec un autre véhicule</option>
                        <option value="materiel">Dommages matériels uniquement</option>
                        <option value="corporel">Dommages corporels</option>
                        <option value="vol">Vol ou tentative de vol</option>
                    </select>
                </div>
                                      
                <p class="fw-bold">Assuré tiers</p>
                
                <div class="col-md-4">
                    <label for="nom_tiers" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom_tiers" value="" name= "nom_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="prenom_tiers" class="form-label">Prenom</label>
                    <input type="text" class="form-control" id="prenom_tiers" value="" name="prenom_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_tel_tiers" class="form-label">Numéro de téléphone</label>
                    <input type="tel" class="form-control" id="num_tel_tiers" value="" name="num_tel_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_pol_tiers" class="form-label">Numéro de police du contrat</label>
                    <input type="tel" class="form-control" id="num_pol_tiers" value="" name="num_pol_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nom_assurance_tiers" class="form-label">Nom de la compagnie assurance tiers</label>
                    <input type="tel" class="form-control" id="nom_assurance_tiers" value="" name="nom_assurance_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="contact_assurance_tiers" class="form-label">Contact de l'assurance tiers</label>
                    <input type="tel" class="form-control" id="contact_assurance_tiers" value="" name="contact_assurance_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="num_matri_tiers" class="form-label">Numéro de matricule de la voiture</label>
                    <input type="text" class="form-control" id="num_matri_tiers" value="" name="num_matri_tiers" >
                    <div class="valid-feedback">
                    Looks good!
                    </div>
                </div>
                

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </div>
            </form>
       </div>
    </div>
</div>
@endsection