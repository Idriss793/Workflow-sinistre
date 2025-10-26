<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title. ' Automobile - SUNU Assurances')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
      <style>
        :root {
        --primary-gradient: linear-gradient(135deg, #9E1B32 0%, #B7323C 100%);
        --secondary-gradient: linear-gradient(135deg, #444444 0%, #666666 100%);
        --warning-gradient: linear-gradient(135deg, #f5a623 0%, #f0932b 100%);
        --expert-color: #9E1B32;       /* Couleur principale SUNU */
        --expert-secondary: #444444;   /* Couleur secondaire (auto, gris) */
        }

        /* Navbar principale */
        .expert-navbar {
            background: var(--primary-gradient);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(158, 27, 50, 0.3);
            border: none;
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.75rem 0;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: rgba(255,255,255,0.9) !important;
            transform: scale(1.02);
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

        .expert-title {
            background: rgba(255,255,255,0.1);
            padding: 8px 20px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .expert-title:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        /* Navigation secondaire */
        .secondary-nav {
            background: #fff;
            border-bottom: 2px solid #9E1B32;
            padding: 0.5rem 0;
        }

        .nav-pills .nav-link {
            border-radius: 20px;
            padding: 8px 20px;
            margin: 0 4px;
            color: #444;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-pills .nav-link:hover {
            color: #9E1B32;
            background: rgba(158, 27, 50, 0.1);
            border-color: rgba(158, 27, 50, 0.2);
            transform: translateY(-1px);
        }

        .nav-pills .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(158, 27, 50, 0.3);
        }

        /* Notifications et profil */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification-btn {
            position: relative;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .notification-btn:hover {
            background: rgba(255,255,255,0.25);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--warning-gradient);
            color: white;
            font-size: 0.75rem;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.15);
            padding: 6px 15px 6px 6px;
            border-radius: 25px;
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            background: rgba(255,255,255,0.25);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--secondary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            border: 2px solid white;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* Menu déroulant */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.95);
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .expert-title {
                display: none;
            }
            
            .navbar-actions {
                gap: 10px;
            }
            
            .user-info {
                display: none;
            }
            
            .secondary-nav {
                padding: 0.25rem 0;
            }
            
            .nav-pills .nav-link {
                padding: 6px 12px;
                font-size: 0.85rem;
            }
        }

        /* Animations d'entrée */
        .navbar-brand, .expert-title, .notification-btn, .user-profile {
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Sidebar toggle pour mobile */
        .sidebar-toggle {
            display: none;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.2);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        @media (max-width: 992px) {
            .sidebar-toggle {
                display: flex;
            }
        }

        /* Indicateur de statut expert */
        .expert-status {
            position: relative;
        }

        .expert-status::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: #28a745;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

    </style>
</head>
<body>
    <!-- Navbar principale -->
    <nav class="navbar navbar-expand-lg expert-navbar">
        <div class="container-fluid">
            <!-- Menu toggle pour mobile -->
            <button class="sidebar-toggle me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#expertSidebar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Logo et marque -->
            <a class="navbar-brand" href="{{ url($url) }}">
                <img src="{{ asset('image/sunu.png') }}" alt="SUNU Assurances" class="brand-logo">
                <span class="d-none d-md-inline">SUNU Assurances</span>
            </a>

            <!-- Titre de la section -->
            <div class="expert-title d-none d-lg-flex mx-auto">
                <i class="fas fa-user-tie"></i>
                <span>{{$title}}  Automobile</span>
            </div>

            <!-- Actions navbar -->
            <div class="navbar-actions">
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="notification-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge" id="notificationCount">3</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 320px;">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-bell me-2"></i>Notifications</span>
                            <small class="text-muted">3 nouvelles</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="dropdown-header mb-1">Nouveau sinistre assigné</h6>
                                        <p class="mb-0 text-muted small">Sinistre #SIN-2024-001234</p>
                                        <small class="text-muted">Il y a 5 minutes</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-info"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="dropdown-header mb-1">Rappel d'expertise</h6>
                                        <p class="mb-0 text-muted small">2 dossiers en attente</p>
                                        <small class="text-muted">Il y a 1 heure</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#"><i class="fas fa-eye me-2"></i>Voir toutes les notifications</a></li>
                    </ul>
                </div>

                <!-- Profil utilisateur -->
                <div class="dropdown">
                    <a class="user-profile" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar expert-status">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="user-info d-none d-md-block">
                            <div class="user-name">Mr. Jean Does</div>
                            <div class="user-role">{{$title}} Automobile</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2 d-none d-md-inline"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ url('profileGestionnaire') }}">
                                <i class="fas fa-user-circle"></i>
                                <span>Mon Profil</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-chart-line"></i>
                                <span>Statistiques</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a class="dropdown-item text-danger" href="#"  onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Navigation secondaire -->
    <nav class="secondary-nav">
        <div class="container-fluid">
            <ul class="nav nav-pills justify-content-center justify-content-md-start">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{url('home')}}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-file-alt me-2"></i>Rapport
                    </a>
                </li>
                
            </ul>
        </div>
    </nav>

    <!-- Sidebar mobile (Offcanvas) -->
    <!-- <div class="offcanvas offcanvas-start" tabindex="-1" id="expertSidebar" aria-labelledby="expertSidebarLabel">
        <div class="offcanvas-header" style="background: var(--primary-gradient); color: white;">
            <h5 class="offcanvas-title" id="expertSidebarLabel">
                <i class="fas fa-user-tie me-2"></i>Expert Automobile
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">
                        <i class="fas fa-file-medical-alt me-3"></i>Mes Sinistres
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">
                        <i class="fas fa-file-alt me-3"></i>Rapports
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">
                        <i class="fas fa-calendar-alt me-3"></i>Planning
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">
                        <i class="fas fa-history me-3"></i>Historique
                    </a>
                </li>
            </ul>
            <hr>
            <div class="d-grid gap-2">
                <a href="#" class="btn btn-outline-primary">
                    <i class="fas fa-user-circle me-2"></i>Mon Profil
                </a>
                <a href="#" class="btn btn-outline-secondary">
                    <i class="fas fa-cog me-2"></i>Paramètres
                </a>
            </div>
        </div>
    </div> -->

    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   
      <script>
        

        

        // Third party fields toggle
        function toggleThirdPartyFields() {
            const checkbox = document.getElementById('has_third_party');
            const section = document.getElementById('third_party_section');
            
            if (checkbox.checked) {
                section.classList.remove('d-none');
            } else {
                section.classList.add('d-none');
            }
        }

        // Form validation
        document.getElementById('claimForm').addEventListener('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                this.classList.add('was-validated');
            }
            // sinon, Laravel traitera le formulaire normalement
        });

        // Auto-format license plate to uppercase
        document.getElementById('num_matri').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('num_matri_tiers').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Limit date selection to past and present
        document.getElementById('date_sinistre').setAttribute('max', new Date().toISOString().split('T')[0]);

        // Close sidebar when clicking backdrop
        document.getElementById('sidebarBackdrop').addEventListener('click', toggleSidebar);

        // Responsive behavior
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth > 768) {
                backdrop.classList.add('d-none');
            } else {
                mainContent.classList.remove('shifted');
            }
         
        });

        // Initialize form validation styles
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
           
    </script>
    @stack('scripts')
</body>
</html>