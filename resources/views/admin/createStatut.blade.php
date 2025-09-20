@extends('templates.navbar')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{route('admin.store')}}" id="statutForm" class="needs-validation p-4 shadow-lg rounded bg-white border" novalidate>
        @csrf
            <h4 class="mb-4 text-primary fw-bold text-center">
                <i class="fas fa-tasks me-2"></i>Gestion des Statuts
            </h4>

            <!-- Libellé du statut -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="lib_statut" name="lib_statut" placeholder="Nom du statut" required>
                <label for="lib_statut">Libellé du statut *</label>
                <div class="invalid-feedback">
                    Veuillez saisir le libellé du statut.
                </div>
            </div>

            <!-- Description -->
            <div class="form-floating mb-3">
                <textarea class="form-control" id="description_statut" name="description_statut" 
                        placeholder="Description" style="height: 120px"></textarea>
                <label for="description_statut">Description</label>
            </div>

            <!-- Ordre d'affichage -->
            <div class="form-floating mb-4">
                <input type="number" class="form-control" id="ordre_statut" name="ordre_statut" 
                    placeholder="Ordre" min="1" max="10">
                <label for="ordre_statut">Ordre d'affichage</label>
            </div>

            <!-- Bouton -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
            </div>
        </form>

        
@endsection



