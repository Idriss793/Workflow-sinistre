@extends('layouts.appLogin')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="mb-4 text-center">Enregistrer un nouvel utilisateur</h1>

        <form method="POST" action="#">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Numéro de téléphone</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Rôle</label>
                <select class="form-select" name="role" id="">
                    <option value="">Choisir un rôle</option>
                    <option value="gestionnaire">Gestionnaire</option>
                    <option value="expert">Expert</option>
                    <option value="comptable">Comptable</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" value="Admin123" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@endsection
