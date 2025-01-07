@extends('layouts.app')

@section('content')
    <h1>Créer un nouveau site</h1>
    <form action="{{ route('sites.store') }}" method="POST">
        @csrf
        <div>
            <label for="numero_site">Numéro Site:</label>
            <input type="text" name="numero_site" id="numero_site" required>
        </div>
        <div>
            <label for="nom_site">Nom Site:</label>
            <input type="text" name="nom_site" id="nom_site" required>
        </div>
        <div>
            <label for="technologie">Technologie:</label>
            <input type="text" name="technologie" id="technologie" required>
        </div>
        <div>
            <label for="etape_avancement">Étape Avancement:</label>
            <input type="text" name="etape_avancement" id="etape_avancement" required>
        </div>
        <div>
            <label for="responsable">Responsable:</label>
            <input type="text" name="responsable" id="responsable" required>
        </div>
        <div>
            <label for="date_debut_etape">Date Début Étape:</label>
            <input type="date" name="date_debut_etape" id="date_debut_etape" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection