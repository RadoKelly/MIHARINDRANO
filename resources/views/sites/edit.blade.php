@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Modifier le Site</h1>

        <form action="{{ route('sites.update', $site) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="numero_site" class="block text-sm font-medium text-gray-700">Numéro Site</label>
                <input type="text" name="numero_site" id="numero_site" value="{{ $site->numero_site }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="nom_site" class="block text-sm font-medium text-gray-700">Nom Site</label>
                <input type="text" name="nom_site" id="nom_site" value="{{ $site->nom_site }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="technologie" class="block text-sm font-medium text-gray-700">Technologie</label>
                <input type="text" name="technologie" id="technologie" value="{{ $site->technologie }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="etape_avancement" class="block text-sm font-medium text-gray-700">Étape Avancement</label>
                <input type="text" name="etape_avancement" id="etape_avancement" value="{{ $site->etape_avancement }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="responsable" class="block text-sm font-medium text-gray-700">Responsable</label>
                <input type="text" name="responsable" id="responsable" value="{{ $site->responsable }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="date_debut_etape" class="block text-sm font-medium text-gray-700">Date Début Étape</label>
                <input type="date" name="date_debut_etape" id="date_debut_etape" value="{{ $site->date_debut_etape }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Bouton Submit pour enregistrer les modifications -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection