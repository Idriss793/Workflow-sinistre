<div class="tab-pane fade"  id="documents" role="tabpanel">
    <h5>État des documents</h5>
    <ul class="list-group mb-4">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Photos des dégâts
            <i class="fas fa-check-circle text-success"></i>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Constat amiable signé
            <i class="fas fa-times-circle text-danger"></i>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Copie de la carte grise
            <i class="fas fa-check-circle text-success"></i>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Relevé d'informations permis
            <i class="fas fa-times-circle text-danger"></i>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            Devis de réparation
            <i class="fas fa-check-circle text-success"></i>
        </li>
    </ul>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Documents téléversés</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Nom</th>
                        <th>Taille</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sinistres->documents as $document)
                    <tr>
                        <td>{{$document->type_doc}}</td>
                        <td>{{$document->nom_fichier}}</td>
                        <td>{{$document->taille}}</td>
                        <td>{{$document->created_at}}</td>
                        <td class="text-center">
                            <a href="{{asset('storage/' . $document->path)}}" target="_blank" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{asset('storage/' . $document->path)}}" download class="btn btn-sm btn-success">Télécharger</a>
                        </td>
                    </tr>
                            
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</di