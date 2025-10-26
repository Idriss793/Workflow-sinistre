@section('content')
    <div class="container py-5">
        <!-- ====== Titre de la page ====== -->
        <div class="mb-4">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-user-circle me-2 text-primary"></i> Mon profil
            </h2>
            <hr class="mt-3">
        </div>

        <!-- ====== Section Profil ====== -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">

                        <!-- ====== Avatar / En-tête ====== -->
                        <div class="text-center mb-5">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold fs-1 d-inline-flex justify-content-center align-items-center mb-3" 
                                style="width: 120px; height: 120px;">
                                J
                            </div>
                            <h4 class="fw-bold text-dark mb-0">Jean Doe</h4>
                            <p class="text-muted mb-0">jeandoe@gmail.com</p>
                        </div>

                        <!-- ====== Informations ====== -->
                        <div class="px-2 mb-4">
                            <div class="row mb-3">
                                <div class="col-sm-4 text-secondary fw-semibold">Téléphone :</div>
                                <div class="col-sm-8 text-dark">+241 07 78 89 988</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-secondary fw-semibold">Rôle :</div>
                                <div class="col-sm-8 text-dark">Utilisateur Gestionnaire</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-secondary fw-semibold">Statut :</div>
                                <div class="col-sm-8">
                                    <span class="text-success fw-semibold">Actif</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-secondary fw-semibold">Adresse :</div>
                                <div class="col-sm-8 text-dark">Libreville, Gabon</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 text-secondary fw-semibold">Date d’inscription :</div>
                                <div class="col-sm-8 text-dark">12 Janvier 2024</div>
                            </div>
                        </div>

                        <hr>

                        <!-- ====== Boutons ====== -->
                        <div class="text-center">
                            <a href="#" class="btn btn-primary rounded-pill px-4 me-2">
                                <i class="fas fa-user-edit me-1"></i> Modifier
                            </a>
                            <button class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection