<div class="tab-pane fade show active" id="info" role="tabpanel">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Informations sur le sinistre</h5>
            <span class="badge bg-info fs-6">En cours de traitement</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Date du sinistre :</strong><br>{{ \Carbon\Carbon::parse($sinistres->created_at)->translatedFormat('d F Y')}}
                </div>
                <div class="col-md-6">
                    <strong>Lieu du sinistre :</strong><br>{{$sinistres->lieu}}
                </div>
            </div>
            <p><strong>Description :</strong><br>{{$sinistres->description}}</p>
            <p><strong>Type de sinistre :</strong>{{$sinistres->type_sinistre}}</p>
            <p>
                <strong>Statut :</strong>
                <span class="badge bg-primary">
                    {{ $sinistres->statut->lib_statut}}
                </span>
            </p>
        </div>
    </div>

    <h5>Photos du sinistre</h5>
    <div class="row">
        @foreach($sinistres->documents->whereIn('type_doc', ['photos']) as $document)
            <div class="col-md-3 mb-3">
                <div class="card" >
                    <img src="{{ asset('storage/' . $document->path) }}"class="card-img-top img-hover-zoom rounded" alt="Image"> 
                </div>
            </div>
        @endforeach
    </div>
</div>