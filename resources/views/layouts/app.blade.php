<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration de Sinistre - Assurance Auto</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .logo {
            width: 150px; /* tu peux ajuster */
            height: auto;
        }
        :root {
            --bs-primary: #1e3d59;
            --bs-secondary: #3498db;
            --bs-success: #27ae60;
            --bs-info: #17a2b8;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545;
            --bs-light: #e8f4f8;
            --bs-dark: #2c3e50;
        }

        .bg-primary-gradient {
            background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-secondary) 100%);
        }

        .bg-light-gradient {
            background: linear-gradient(135deg, var(--bs-light) 0%, #ffffff 100%);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100vh;
            background-color: var(--bs-primary);
            transition: all 0.3s ease;
            z-index: 1050;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar .nav-link {
            color: #ecf0f1;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .nav-link:hover {
            background-color: var(--bs-secondary);
            color: white;
        }

        .main-content {
            transition: margin-left 0.3s ease;
        }

        .main-content.shifted {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .main-content.shifted {
                margin-left: 0;
            }
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--bs-secondary);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .required::after {
            content: ' *';
            color: var(--bs-danger);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--bs-secondary) 0%, var(--bs-primary) 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .progress-step {
            display: flex;
            align-items: center;
            color: #6c757d;
        }

        .progress-step.active {
            color: var(--bs-secondary);
            font-weight: bold;
        }

        .progress-step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #6c757d;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .progress-step.active .progress-step-number {
            background-color: var(--bs-secondary);
        }

        .file-upload-area {
            border: 2px dashed var(--bs-secondary);
            background-color: var(--bs-light);
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            background-color: rgba(52, 152, 219, 0.1);
        }

        .section-divider {
            border-bottom: 3px solid var(--bs-secondary);
            position: relative;
        }

        .section-divider::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 50px;
            height: 3px;
            background-color: var(--bs-success);
        }
    </style>
</head>
<body class="bg-light-gradient">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary-gradient">
        <div class="container-fluid">
            <button class="btn btn-outline-light me-3" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
             <h2 class="text-white "><i class=" bi-file-medical-alt me-2"></i>{{$title}} sinistre</h2>
            <button class="btn btn-outline-primary position-relative" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" id="notificationCount">0</span>
            </button>
            <!-- <a class="navbar-brand text-white fw-bold fs-4" href="#">
                <i class="bi bi-car-front me-2"></i>SUNU Assurance
            </a> -->
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3 text-center border-bottom border-secondary">
            <h4 class="text-white mb-0" style="cursor: pointer;" onclick="toggleSidebar()">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('image/sunu.png') }}" alt="SUNU Assurances" width="40" height="40" class="me-2">
                    <span class="navbar-brand text-white fw-bold fs-5">SUNU Assurances</span>
                </a>
            </h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link py-3 px-4" href="{{url('home')}}">
                <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
            </a>
            <a class="nav-link py-3 px-4 " href="{{url('declarerSinistre')}}">
                <i class="bi bi-exclamation-triangle me-2"></i>Déclarer un sinistre v1
            </a>
            <a class="nav-link py-3 px-4 " href="{{url('formSinistre')}}">
                <i class="bi bi-plus me-2"></i>Déclarer un sinistre v2
            </a>
        </nav>
    </div>

    <!-- Sidebar backdrop -->
    <div class="offcanvas-backdrop fade show d-none" id="sidebarBackdrop" onclick="toggleSidebar()"></div>
    <div class="main-content" id="mainContent">
    <!-- Main content -->
    @yield('content')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('show');
            
            if (window.innerWidth <= 768) {
                backdrop.classList.toggle('d-none');
            } else {
                mainContent.classList.toggle('shifted');
            }
        }

        // Sidebar toggle button
        document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

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
</body>
</html>