@extends('layouts.appLogin')

@section('content')

<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        color: #fff;
        overflow: hidden;
    }

    /* ======== Vidéo de fond ======== */
    .bg-video {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    /* ======== Couche de couleur si pas de vidéo ======== */
    .bg-fallback {
        background: radial-gradient(circle at top, #003366, #001a33);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -2;
    }

    /* ======== Overlay sombre ======== */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 15, 30, 0.6);
        z-index: -1;
    }

    /* ======== Carte de connexion ======== */
    .login-card {
        background: rgba(0, 25, 50, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        width: 360px;
        margin: auto;
        padding: 40px 35px;
        text-align: center;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-card h4 {
        margin-bottom: 20px;
        color: #00c6ff;
        font-weight: 600;
    }

    .form-control {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 10px;
        color: #fff;
        padding: 10px 15px;
        margin-bottom: 20px;
    }

    .form-control:focus {
        border-color: #00c6ff;
        box-shadow: 0 0 0 0.2rem rgba(0, 198, 255, 0.25);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .btn-login {
        background: linear-gradient(90deg, #00c6ff, #0072ff);
        border: none;
        border-radius: 10px;
        padding: 10px;
        width: 100%;
        color: #fff;
        font-weight: 600;
        transition: transform 0.2s;
    }

    .btn-login:hover {
        transform: scale(1.03);
    }

    .text-links {
        font-size: 0.85rem;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    .text-links a {
        color: #00c6ff;
        text-decoration: none;
    }

    .text-links a:hover {
        text-decoration: underline;
    }

     .brand-logo {
            width: 45px;
            height: 45px;
            margin-right: 12px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .brand-logo:hover {
            transform: rotate(5deg) scale(1.1);
        }

    /* ======== Image de fond ======== */
    .bg-image {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -2;
        animation: fadeInBg 2s ease-in-out;
    }

    @keyframes fadeInBg {
        from { opacity: 0; }
        to { opacity: 1; }
    }

</style>


@if(file_exists(public_path('image/imagefond.jpg')))
    <div class="bg-image" style="background-image: url('{{ asset('image/imagefond.jpg') }}');"></div>
@else
    <div class="bg-fallback"></div>
@endif
<div class="overlay"></div>


<!-- Contenu principal -->
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="{{ asset('image/sunu.png') }}" alt="Logo"  class="brand-logo">
            <h4>Connexion SUNU Assurance</h4>
        </div>

        <form method="POST" action="{{ route('auth.connection') }}">
            @csrf
            <input type="text-white" name="identifier" class="form-control" placeholder="Adresse email ou téléphone" required autofocus
                value="{{ old('identifier') }}">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            <button type="submit" class="btn btn-login">Se connecter</button>

            <!-- Affichage des erreurs -->
            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('status'))
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif
        </form>

        <div class="text-links">
            <a href="#">Mot de passe oublié ?</a>
        </div>
    </div>
</div>

@endsection


