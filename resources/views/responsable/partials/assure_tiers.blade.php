<div class="tab-pane fade" id="assure-tiers" role="tabpanel">
    <div class="row g-3">
        @foreach ($sinistres->assureTiers as $assure_tiers)
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h6 class="mb-0">Assuré tiers</h6>
                    </div>
                        
                    <div class="card-body">
                        <p><strong>Nom :</strong> {{$assure_tiers->nom_tiers}}</p>
                        <p><strong>Prénom :</strong> {{$assure_tiers->prenom_tiers}}</p>
                        <p><strong>Téléphone :</strong> {{$assure_tiers->num_tel_tiers}}</p>
                        <p><strong>Numéro de police :</strong> {{$assure_tiers->num_pol_tiers}}</p>
                        <p><strong>Matricule :</strong> {{$assure_tiers->num_matri_tiers}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h6 class="mb-0">Compagnie assurance tiers</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Compagnie :</strong> {{$assure_tiers->nom_assurance_tiers}}</p>
                        <p><strong>Localisation :</strong> {{$assure_tiers->contact_assurance_tiers}}</p>
                               
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>