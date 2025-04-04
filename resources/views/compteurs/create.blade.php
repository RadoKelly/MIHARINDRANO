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

                    <div class="col-span-1 relative">
                        <label for="client_search" class="block text-sm font-medium text-gray-700">Nom Client</label>

                        <!-- Champ de recherche -->
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
                    </div>



                    <div class="col-span-1">
                        <label for="date_releve" class="block text-sm font-medium text-gray-700">Date du Relevé</label>
                        <input type="date" id="date_releve" name="date_releve"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="col-span-1">
                        <label for="numero_facture" class="block text-sm font-medium text-gray-700">N° Facture</label>
                        <input type="text" id="numero_facture" name="numero_facture"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="col-span-1">
                        <label for="nouvel_index" class="block text-sm font-medium text-gray-700">Nouvel Index</label>
                        <input type="number" id="nouvel_index" name="nouvel_index"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                    </div>

                    <div class="col-span-1">
                        <label for="tarif_id" class="block text-sm font-medium text-gray-700">Tarif</label>
                        <select id="tarif_id" name="tarif_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                            required>
                            <option value="">Sélectionnez un tarif</option>
                            <option value="1">compteur 1</option>
                        </select>
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
            /* Assurez-vous que le z-index est plus élevé que les autres éléments */

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
            const form = document.querySelector('form'); // Sélectionne le formulaire pour la soumission

            // Affichage dans la console pour vérifier le chargement du script
            // console.log('Script chargé avec succès !');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.trim();
                console.log('Saisie utilisateur :', query); // Vérifie la saisie

                // Si la saisie est inférieure à 2 caractères, ne pas lancer la recherche
                if (query.length < 2) {
                    clientResults.classList.add('hidden'); // Masquer les résultats si moins de 2 caractères
                    return;
                }

                // console.log('Lancement de la recherche...');

                // Requête AJAX pour récupérer les clients correspondants
                fetch("{{ route('clients.search') }}?query=" + query)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Réponse reçue :', data); // Vérifie les données retournées
                        clientResults.innerHTML = ''; // Réinitialiser la liste

                        if (data.length === 0) {
                            clientResults.innerHTML = '<li class="p-2">Aucun client trouvé</li>';
                            clientResults.classList.remove('hidden'); // Afficher la liste
                            return;
                        }

                        // Réinitialiser et ajouter les résultats à la liste déroulante
                        clientResults.classList.remove('hidden'); // Afficher la liste

                        data.forEach(client => {
                            const li = document.createElement('li');
                            li.textContent = client.nom_client;
                            li.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');

                            // Ajouter un événement de sélection d'un client
                            li.addEventListener('click', function() {
                                searchInput.value = client
                                    .nom_client; // Mettre à jour le champ de recherche
                                clientIdInput.value = client
                                .id; // Mettre à jour l'ID du client caché
                                console.log('ID du client sélectionné:', clientIdInput
                                    .value);
                                clientResults.classList.add(
                                    'hidden'); // Masquer la liste après la sélection
                            });

                            clientResults.appendChild(li); // Ajouter chaque client à la liste
                        });
                    })
                    .catch(error => {
                        console.error('Erreur AJAX:', error); // Log de l'erreur si la requête échoue
                    });
            });




            // Optionnel : Vérification du client_id lors de la soumission du formulaire
            form.addEventListener('submit', function(event) {
                console.log("client_id avant soumission:", clientIdInput.value); // Affiche l'ID du client
                if (!clientIdInput.value) {
                    alert("Veuillez sélectionner un client.");
                    event.preventDefault(); // Empêcher la soumission si aucun client n'est sélectionné
                }
            });
        });
    </script>
@endsection
