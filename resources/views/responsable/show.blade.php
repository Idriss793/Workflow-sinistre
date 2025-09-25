@extends('templates.navbar')
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
        <a href="{{ url('/indexResponsable') }}" class="btn btn-outline-secondary ">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
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
                Infos Sinistre
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-principal-tab" data-bs-toggle="tab" data-bs-target="#assure-principal" type="button" role="tab">
                Assuré principal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="assure-tiers-tab" data-bs-toggle="tab" data-bs-target="#assure-tiers" type="button" role="tab">
                Assuré tiers
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                Documents
            </button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content py-4" id="sinistreTabsContent">

        <!-- Infos Sinistre -->
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

        <!-- Assuré principal -->
        
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

        <!-- Assuré tiers -->
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
      

        <!-- Documents -->
        <div class="tab-pane fade" id="documents" role="tabpanel">
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
                
        </div>
    </div>
</div>
@endsection
