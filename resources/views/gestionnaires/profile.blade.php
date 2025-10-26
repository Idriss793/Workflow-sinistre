@extends('templates.navbar2')









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
                                M
                            </div>
                            <h4 class="fw-bold text-dark mb-0">Mon Nom</h4>
                            <p class="text-muted mb-0">monemail@example.com</p>
                        </div>

                        <!-- ====== Formulaire Profil ====== -->
                        <form>
                            <div class="px-2 mb-4">
                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Nom complet :</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" value="Mon Nom">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Email :</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" value="monemail@example.com">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Téléphone :</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="telephone" class="form-control" value="07 00 00 00 00">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Adresse :</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="adresse" class="form-control" value="Libreville, Gabon">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Mot de passe actuel :</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="current_password" class="form-control" placeholder="Entrez votre mot de passe actuel">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Nouveau mot de passe :</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="new_password" class="form-control" placeholder="Entrez le nouveau mot de passe">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Statut :</label>
                                    <div class="col-sm-8">
                                        <span class="text-success fw-semibold">Actif</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4 text-secondary fw-semibold">Rôle :</div>
                                    <div class="col-sm-8 text-dark">Utilisateur Gestionnaire</div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 text-secondary fw-semibold">Date d’inscription :</label>
                                    <div class="col-sm-8 text-dark">23 Oct 2025</div>
                                </div>
                            </div>

                            <hr>

                            <!-- ====== Boutons ====== -->
                            <div class="text-center">
                                <button type="button" class="btn btn-primary rounded-pill px-4 me-2">
                                    <i class="fas fa-save me-1"></i> Sauvegarder
                                </button>
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

