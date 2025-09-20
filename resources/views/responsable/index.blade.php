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
    <style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
</head>
<body class="bg-light-gradient">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-primary-gradient">
        <div class="container-fluid text-center">
            <i><img src="{{ asset('image/sunu.png') }}" alt="SUNU Assurances" width="40" height="40" class="me-2"></i>
            <h2 class="text-white  "><i class=" bi-file-medical-alt me-2"></i>Responsable sinistre</h2>
            <button class="btn btn-outline-primary position-relative" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                <i class="bi bi-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" id="notificationCount">0</span>
            </button>
            <!-- <a class="navbar-brand text-white fw-bold fs-4" href="#">
                <i class="bi bi-car-front me-2"></i>SUNU Assurance
            </a> -->
        </div>
    </nav>

    

   
    <div class="main-content" id="mainContent">
        <div class="container mt-5">
        <!-- Main content -->
            <div class="row mb-5">
                <!-- Carte : Sinis tres déclarés -->
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Sinistres déclarés</h6>
                                    <h2 class="mt-2 mb-0">45</h2>
                                    <p class="mb-0"><small>Ce mois-ci</small></p>
                                </div>
                                <div class="icon-circle">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carte : Sinistres clôturés -->
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Sinistres clôturés</h6>
                                    <h2 class="mt-2 mb-0">28</h2>
                                    <p class="mb-0"><small>Ce mois-ci</small></p>
                                </div>
                                <div class="icon-circle">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carte : Taux de clôture -->
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">Taux de clôture</h6>
                                    <h2 class="mt-2 mb-0">62%</h2>
                                    <p class="mb-0"><small>Performance</small></p>
                                </div>
                                <div class="icon-circle">
                                    <i class="fas fa-chart-line fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Carte : En attente validation -->
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-0">En attente validation</h6>
                                    <h2 class="mt-2 mb-0">12</h2>
                                    <p class="mb-0"><small>À traiter</small></p>
                                </div>
                                <div class="icon-circle">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="sinistresTable">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th class="sortable" data-sort="numero">
                                        N° Sinistre <i class="fas fa-sort sort-arrow"></i>
                                    </th>
                                    <th class="sortable" data-sort="date">
                                        Date <i class="fas fa-sort sort-arrow"></i>
                                    </th>
                                    <th>Assuré</th>
                                    <th class="sortable" data-sort="statut">
                                        Statut <i class="fas fa-sort sort-arrow"></i>
                                    </th>
                                    <th>Expert</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="sinistresTableBody">
                                @foreach ($sinistres as $sinistre)
                                    <tr>
                                        <td>{{$sinistre->numero_sinistre}}</td>
                                        <td>{{$sinistre->created_at}}</td>
                                        @foreach ($sinistre->assurePrincipals as $assure)
                                            <td>{{ $assure->nom }}</td>
                                        @endforeach
                                        <td>{{ $sinistre->statut->lib_statut }}</td>
                                        <td>Martin</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{route('gestionnaire.showSinistre',$sinistre->id)}}">
                                                <i class="bi bi-eye" >Consulter</i>
                                            </a>
                                            <a class="btn btn-sm btn-success">
                                                <i class="bi bi-user-check"></i> <Var>Valider</Var>
                                            </a>
                                            <a class="btn btn-sm btn-danger">
                                                <i class="bi bi-user-check"></i> <Var>Rejeter</Var>
                                            </a>
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
</body>
</html>