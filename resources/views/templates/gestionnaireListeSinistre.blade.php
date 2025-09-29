@extends('layouts.app')
@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }

    body {
        background: linear-gradient(120deg, #f6f9fc 0%, #e9f4f8 100%);
        font-family: 'Inter', sans-serif;
    }

    .dashboard-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="3" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translate(0, 0) rotate(0deg); }
        100% { transform: translate(-50px, -50px) rotate(360deg); }
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card.primary {
        background: var(--primary-gradient);
        color: white;
    }

    .stat-card.success {
        background: var(--success-gradient);
        color: white;
    }

    .stat-card.info {
        background: var(--info-gradient);
        color: white;
    }

    .stat-card.warning {
        background: var(--warning-gradient);
        color: white;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
        background: rgba(255, 255, 255, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.5rem;
        position: relative;
    }

    .stat-number::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.5);
        transition: width 0.3s ease;
    }

    .stat-card:hover .stat-number::after {
        width: 100%;
    }

    .modern-search {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(102, 126, 234, 0.1);
        border-radius: 15px;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .modern-search:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .modern-select {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(102, 126, 234, 0.1);
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .modern-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-section {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .btn-modern {
        background: var(--primary-gradient);
        border: none;
        border-radius: 15px;
        padding: 1rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }

    .btn-modern:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-success-modern {
        background: var(--success-gradient);
    }

    .btn-success-modern:hover {
        box-shadow: 0 10px 25px rgba(17, 153, 142, 0.4);
    }

    .table-modern {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .table-modern thead {
        background: var(--primary-gradient);
        color: white;
    }

    .table-modern th {
        border: none;
        padding: 1.5rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .table-modern th:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .table-modern td {
        border: none;
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .badge-success-modern {
        background: var(--success-gradient);
        color: white;
    }

    .badge-warning-modern {
        background: var(--warning-gradient);
        color: white;
    }

    .badge-info-modern {
        background: var(--info-gradient);
        color: white;
    }

    .badge-danger-modern {
        background: var(--danger-gradient);
        color: white;
    }

    .modal-modern .modal-content {
        border: none;
        border-radius: 25px;
        backdrop-filter: blur(20px);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    .modal-modern .modal-header {
        background: var(--primary-gradient);
        color: white;
        border-radius: 25px 25px 0 0;
        border: none;
        padding: 2rem;
    }

    .btn-action {
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        margin: 0.2rem;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease;
    }

    .btn-action:hover::before {
        width: 100px;
        height: 100px;
    }

    .btn-primary-action {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-success-action {
        background: var(--success-gradient);
        color: white;
    }

    .btn-primary-action:hover,
    .btn-success-action:hover {
        transform: translateY(-2px);
        color: white;
    }

    .sort-arrow {
        transition: all 0.3s ease;
        opacity: 0.5;
    }

    .sortable:hover .sort-arrow {
        opacity: 1;
        transform: scale(1.2);
    }

    .alert-modern {
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
        margin: 1rem 0;
        position: relative;
        overflow: hidden;
    }

    .alert-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
    }

    .alert-success-modern {
        background: rgba(17, 153, 142, 0.1);
        color: #0f7b6c;
        border-left: 4px solid #11998e;
    }

    .alert-danger-modern {
        background: rgba(255, 154, 158, 0.1);
        color: #d63384;
        border-left: 4px solid #ff9a9e;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1.5rem;
        }
        
        .filter-section {
            padding: 1rem;
        }
        
        .dashboard-header {
            padding: 1.5rem;
            text-align: center;
        }
    }
</style>

<div class="container-fluid mt-4">
    <!-- En-tête du dashboard -->
    <div class="dashboard-header fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2 fw-bold">📊 Tableau de Bord Gestionnaire</h1>
                <p class="mb-0 opacity-90">Gérez efficacement vos sinistres et experts</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <div class="me-3">
                        <small class="opacity-75">Dernière mise à jour</small><br>
                        <strong>{{ date('d/m/Y H:i') }}</strong>
                    </div>
                    <i class="fas fa-sync fa-spin opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card primary fade-in" style="animation-delay: 0.1s;">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div class="stat-number pulse">45</div>
                <h6 class="fw-bold mb-1">Sinistres déclarés</h6>
                <small class="opacity-75">Ce mois-ci</small>
                <div class="mt-2">
                    <small class="badge badge-modern" style="background: rgba(255,255,255,0.2);">
                        +12% ce mois
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card success fade-in" style="animation-delay: 0.2s;">
                <div class="stat-icon">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div class="stat-number pulse">28</div>
                <h6 class="fw-bold mb-1">Sinistres clôturés</h6>
                <small class="opacity-75">Ce mois-ci</small>
                <div class="mt-2">
                    <small class="badge badge-modern" style="background: rgba(255,255,255,0.2);">
                        +8% ce mois
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card info fade-in" style="animation-delay: 0.3s;">
                <div class="stat-icon">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <div class="stat-number pulse">62%</div>
                <h6 class="fw-bold mb-1">Taux de clôture</h6>
                <small class="opacity-75">Performance</small>
                <div class="mt-2">
                    <small class="badge badge-modern" style="background: rgba(255,255,255,0.2);">
                        Excellent
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stat-card warning fade-in" style="animation-delay: 0.4s;">
                <div class="stat-icon">
                    <i class="fas fa-clock fa-2x"></i>
                </div>
                <div class="stat-number pulse">12</div>
                <h6 class="fw-bold mb-1">En attente validation</h6>
                <small class="opacity-75">À traiter</small>
                <div class="mt-2">
                    <small class="badge badge-modern" style="background: rgba(255,255,255,0.2);">
                        Priorité
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des filtres -->
    <div class="filter-section fade-in" style="animation-delay: 0.5s;">
        <form method="GET" action="{{ route('gestionnaire.home') }}">
            <div class="row align-items-end">
                <div class="col-lg-3 col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-2"></i>Recherche
                    </label>
                    <div class="position-relative">
                        <input type="text" class="form-control modern-search" name="search" 
                               placeholder="N° sinistre, nom assuré..." value="{{ request('search') }}">
                        <i class="fas fa-search position-absolute" style="top: 50%; right: 15px; transform: translateY(-50%); opacity: 0.5;"></i>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-filter me-2"></i>Statut
                    </label>
                    <select class="form-select modern-select" name="statut" onchange="this.form.submit()">
                        <option value="">Tous les statuts</option>
                        <option value="1" {{ request('statut')=='1' ? 'selected' : '' }}>En attente de document</option>
                        <option value="2" {{ request('statut')=='2' ? 'selected' : '' }}>En attente expert</option>
                        <option value="3" {{ request('statut')=='3' ? 'selected' : '' }}>En attente expertise</option>
                        <option value="4" {{ request('statut')=='4' ? 'selected' : '' }}>Rejeté</option>
                        <option value="5" {{ request('statut')=='5' ? 'selected' : '' }}>Clôturé</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tags me-2"></i>Type
                    </label>
                    <select class="form-select modern-select" name="type_sinistre" onchange="this.form.submit()">
                        <option value="">Tous types</option>
                        <option value="collision" {{ request('type_sinistre')=='collision' ? 'selected' : '' }}>Collision</option>
                        <option value="vol" {{ request('type_sinistre')=='vol' ? 'selected' : '' }}>Vol</option>
                        <option value="materiel" {{ request('type_sinistre')=='materiel' ? 'selected' : '' }}>Matériel</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-calendar me-2"></i>Date
                    </label>
                    <input type="date" name="date_declaration" class="form-control modern-search" 
                           value="{{ request('date_declaration') }}" onchange="this.form.submit()">
                </div>

                <div class="col-lg-3 col-md-12 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-modern flex-fill">
                            <i class="fas fa-search me-2"></i>Rechercher
                        </button>
                        <button type="button" class="btn btn-success-modern btn-modern" data-bs-toggle="modal" data-bs-target="#addSinistreModal">
                            <i class="fas fa-plus me-2"></i>Nouveau
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Messages d'alerte -->
    @if(session('status'))
        <div class="alert alert-success-modern alert-modern fade-in">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger-modern alert-modern fade-in">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tableau des sinistres -->
    <div class="table-modern fade-in" style="animation-delay: 0.6s;">
        <div class="table-responsive">
            <table class="table mb-0" id="sinistresTable">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="numero">
                            <i class="fas fa-hashtag me-2"></i>N° Sinistre 
                            <i class="fas fa-sort sort-arrow ms-2"></i>
                        </th>
                        <th class="sortable" data-sort="date">
                            <i class="fas fa-calendar me-2"></i>Date 
                            <i class="fas fa-sort sort-arrow ms-2"></i>
                        </th>
                        <th>
                            <i class="fas fa-user me-2"></i>Assuré
                        </th>
                        <th>
                            <i class="fas fa-tag me-2"></i>Type de sinistre
                        </th>
                        <th class="sortable" data-sort="statut">
                            <i class="fas fa-info-circle me-2"></i>Statut 
                            <i class="fas fa-sort sort-arrow ms-2"></i>
                        </th>
                        <th>
                            <i class="fas fa-user-tie me-2"></i>Expert
                        </th>
                        <th>
                            <i class="fas fa-cogs me-2"></i>Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="sinistresTableBody">
                    @foreach ($sinistres as $sinistre)
                        <tr>
                            <td>
                                <span class="badge badge-info-modern">
                                    {{$sinistre->numero_sinistre}}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <strong>{{\Carbon\Carbon::parse($sinistre->created_at)->format('d/m/Y')}}</strong><br>
                                    <small class="text-muted">{{\Carbon\Carbon::parse($sinistre->created_at)->format('H:i')}}</small>
                                </div>
                            </td>
                            <td>
                                @foreach ($sinistre->assurePrincipals as $assure)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                            {{ strtoupper(substr($assure->nom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $assure->nom }}</strong><br>
                                            <small class="text-muted">{{ $assure->prenom }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge badge-modern badge-warning-modern">
                                    {{ $sinistre->type_sinistre }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($sinistre->statut->id) {
                                        1 => 'badge-warning-modern',
                                        2 => 'badge-info-modern', 
                                        3 => 'badge-info-modern',
                                        4 => 'badge-danger-modern',
                                        5 => 'badge-success-modern',
                                        default => 'badge-info-modern'
                                    };
                                @endphp
                                <span class="badge badge-modern {{ $statusClass }}">
                                    {{ $sinistre->statut->lib_statut }}
                                </span>
                            </td>
                            <td>
                                @if($sinistre->experts->isEmpty())
                                    <span class="text-muted">
                                        <i class="fas fa-user-times me-1"></i>Non attribué
                                    </span>
                                @elseif($sinistre->experts->count() === 1)
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                            {{ strtoupper(substr($sinistre->experts->first()->name, 0, 1)) }}
                                        </div>
                                        <span class="badge badge-success-modern">
                                            {{ $sinistre->experts->first()->name }}
                                        </span>
                                    </div>
                                @else
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-users me-1"></i>{{ $sinistre->experts->count() }} Experts
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($sinistre->experts as $expert)
                                                <li>
                                                    <span class="dropdown-item">
                                                        <i class="fas fa-user me-2"></i>{{ $expert->name }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    <a class="btn btn-action btn-primary-action" 
                                       href="{{route('gestionnaire.showSinistre',$sinistre->id)}}"
                                       title="Consulter le sinistre">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <button class="btn btn-action btn-success-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#listExpertModal-{{ $sinistre->id }}"
                                            title="Attribuer à un expert">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center p-4">
            <nav>
                {{ $sinistres->links() }}
            </nav>
        </div>
    </div>
</div>

<!-- Modals pour attribuer expert -->
@foreach($sinistres as $sinistre)
<div class="modal fade modal-modern" id="listExpertModal-{{ $sinistre->id }}" tabindex="-1" 
     aria-labelledby="listExpertModalLabel-{{ $sinistre->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-plus me-2"></i>
                    Attribuer à un expert – Sinistre #{{ $sinistre->numero_sinistre }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
@endforeach
@endsection