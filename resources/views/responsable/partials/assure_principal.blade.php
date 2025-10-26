 <div class="tab-pane fade" id="assure-principal" role="tabpanel">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Assuré principal</h5>
        </div>
        <div class="card-body">
                @foreach ($sinistres->assurePrincipals as $assure)
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Nom :</strong> {{$assure->nom}}</div>
                    <div class="col-md-6"><strong>Prénom :</strong> {{$assure->prenom}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6"><strong>Téléphone :</strong> {{$assure->num_tel}}</div>
                    <div class="col-md-6"><strong>Numéro de police :</strong> {{$assure->num_pol}}</div>
                </div>
                <p><strong>Matricule :</strong> {{$assure->num_matri}}</p>
            @endforeach
        </div>
    </div>
</div>