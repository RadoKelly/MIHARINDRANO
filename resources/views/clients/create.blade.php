@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <h1 class="text-2xl font-bold mb-4">Ajouter un Client</h1>
        <form action="{{ route('clients.store',['site' => $site->id]) }}" method="POST" class="bg-white p-8 rounded shadow-md space-y-4">
            @csrf

            <div class="mb-4">
                <label for="nom_client" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                <input type="text" name="nom_client" id="nom_client" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="adress_client" class="block text-gray-700 text-sm font-bold mb-2">Adresse:</label>
                <input type="text" name="adress_client" id="adress_client" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="localite" class="block text-gray-700 text-sm font-bold mb-2">Localité:</label>
                <input type="text" name="localite" id="localite" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="categorie" class="block text-gray-700 text-sm font-bold mb-2">Catégorie:</label>
                <input type="hidden" name="tarif_id" id="tarif_id">
                <select name="categorie" id="categorie" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="kiosque_eau">Kiosques à eau</option>
                    <option value="branchements_partages">Branchements partagés</option>
                    <option value="branchements_privés">Branchements privés</option>
                    <option value="equivalents_service_public">Equivalents service public</option>
                </select>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const categorieSelect = document.getElementById('categorie');
                        const tarifIdInput = document.getElementById('tarif_id');
                
                        const categorieTarifMap = {
                            'kiosque_eau': 1,              // compteur 1
                            'branchements_partages': 2,    // compteur 2
                            'branchements_privés': 3,      // compteur 3
                            'equivalents_service_public': 4 // compteur 4
                        };
                
                        // Mettre à jour automatiquement le champ tarif_id
                        categorieSelect.addEventListener('change', function () {
                            const selectedCategorie = categorieSelect.value;
                            tarifIdInput.value = categorieTarifMap[selectedCategorie] || '';
                        });
                
                        // Déclencher la première fois pour préremplir si besoin
                        categorieSelect.dispatchEvent(new Event('change'));
                    });
                </script>
                
            </div>

            <input type="hidden" name="tarif_id" id="tarif_id">

            <div class="mb-4">
                <label for="date_raccordement" class="block text-gray-700 text-sm font-bold mb-2">Date de raccordement:</label>
                <input type="date" name="date_raccordement" id="date_raccordement" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="ref" class="block text-gray-700 text-sm font-bold mb-2">Référence:</label>
                <input type="text" name="ref" id="ref" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="id_site" class="block text-gray-700 text-sm font-bold mb-2">Site:</label>
                <select value="{{ $site->id }}" name="id_site" id="id_site" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="{{ $site->id }}">{{ $site->nom_site }}</option>
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ajouter</button>
            </div>
        </form>
    </div>
@endsection