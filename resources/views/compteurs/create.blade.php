@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Ajouter un Relevé de Compteur</h1>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('compteurs.store', $site) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <!-- Recherche client -->
                    <div class="col-span-1 relative">
                        <label for="client_search" class="block text-sm font-medium text-gray-700">Nom Client</label>
                        <input type="text" id="client_search" name="client_search"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            placeholder="Recherchez un client..." autocomplete="off">

                        <!-- Liste des clients filtrée -->
                        <ul id="client_results"
                            class="absolute mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                            <!-- Les résultats de recherche seront ajoutés ici -->
                        </ul>

                        <!-- Champ caché pour l'ID du client -->
                        <input type="hidden" id="client_id" name="client_id" required>

                        <!-- Champ caché pour le tarif_id -->
                        <input type="hidden" id="tarif_id" name="tarif_id" required>
                    </div>

                    <!-- Date du Relevé -->
                    <div class="col-span-1">
                        <label for="date_releve" class="block text-sm font-medium text-gray-700">Date du Relevé</label>
                        <input type="date" id="date_releve" name="date_releve"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Nouvel Index -->
                    <div class="col-span-1">
                        <label for="nouvel_index" class="block text-sm font-medium text-gray-700">Nouvel Index</label>
                        <input type="number" id="nouvel_index" name="nouvel_index"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Tarif (Lecture seule) -->
                    <div class="col-span-1">
                        <label for="tarif" class="block text-sm font-medium text-gray-700">Tarif</label>
                        <input type="text" id="tarif" name="tarif" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            placeholder="Le tarif sera automatiquement défini" disabled>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Ajouter le Relevé
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        #client_results {
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background-color: white;
            z-index: 9999;
        }

        #client_results li {
            padding: 8px;
            cursor: pointer;
        }

        #client_results li:hover {
            background-color: #f1f1f1;
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('client_search');
        const clientResults = document.getElementById('client_results');
        const clientIdInput = document.getElementById('client_id');
        const tarifInput = document.getElementById('tarif');
        const tarifIdInput = document.getElementById('tarif_id');
        const form = document.querySelector('form');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            if (query.length < 2) {
                clientResults.classList.add('hidden');
                return;
            }

            fetch("{{ route('compteurs.search', $site) }}?query=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    clientResults.innerHTML = '';
                    if (data.length === 0) {
                        clientResults.innerHTML = '<li class="p-2">Aucun client trouvé</li>';
                        clientResults.classList.remove('hidden');
                        return;
                    }

                    clientResults.classList.remove('hidden');

                    data.forEach(client => {
                        const li = document.createElement('li');
                        li.textContent = client.nom_client;
                        li.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');

                        li.addEventListener('click', function() {
                            searchInput.value = client.nom_client;
                            clientIdInput.value = client.id;
                            tarifInput.value = "Compteur : " + client.tarif_id;
                            tarifInput.placeholder = "Tarif : " + client.tarif_id;
                            tarifIdInput.value = client.tarif_id;
                            clientResults.classList.add('hidden');
                        });

                        clientResults.appendChild(li);
                    });
                })
                .catch(error => {
                    console.error('Erreur AJAX:', error);
                });
        });

        form.addEventListener('submit', function(event) {
            if (!clientIdInput.value) {
                alert("Veuillez sélectionner un client.");
                event.preventDefault();
            }
        });
    });
</script>
@endsection
