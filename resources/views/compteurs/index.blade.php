@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Relevé Consommations Clients</h1>
            <div class="flex mt-4 sm:mt-0 space-x-3">
                <a href="{{ route('sites.compteur.create', $site) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ajouter un Relevé
                </a>
            </div>
        </div>


        <div class="overflow-x-auto relative">
            <table id="clients-table" class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg">
                <thead class="bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">N°
                            Référence</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Nom
                            Client</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Date du
                            Relevé</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Ancienne
                            Date</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">N°
                            Facture</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Tarif
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Ancien
                            Index</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Nouvel
                            Index</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Consommation</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($compteurs as $compteur)
                        <tr>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->id }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->client ? $compteur->client->nom_client : 'Client introuvable' }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->date_releve }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->ancien_date }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->numero_facture }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->tarif_id }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->ancien_index }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->nouvel_index }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->consommation }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('sites.compteur.edit', ['site' => $compteur->site_id, 'compteur' => $compteur->id]) }}"
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <!-- Icône d'édition -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form
                                        action="{{ route('sites.compteur.destroy', ['site' => $compteur->site_id, 'compteur' => $compteur->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce relevé ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <!-- Icône de suppression -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inclure jQuery et DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Initialisation de DataTables -->
    <script>
        $(document).ready(function() {
            $('#clients-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                info: true,
                language: {
                    lengthMenu: "Afficher _MENU_ clients par page",
                    zeroRecords: "Aucun client trouvé",
                    info: "Affichage de la page _PAGE_ sur _PAGES_",
                    infoEmpty: "Aucun client trouvé",
                    infoFiltered: "(filtré à partir de _MAX_ clients)",
                    search: "Recherche:",
                    paginate: {
                        first: "Premier",
                        last: "Dernier",
                        next: "Suivant",
                        previous: "Précédent"
                    }
                }
            });
        });
    </script>

    <!-- Style pour la recherche -->
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

        /* Header de la table */
        table.dataTable thead th {
            background: linear-gradient(45deg, #1d4ed8, #3b82f6);
            color: #fff;
            font-weight: 600;
            border-bottom: 2px solid #2563eb;
        }

        /* Lignes avec effet hover */
        table.dataTable tbody tr {
            transition: background-color 0.3s ease;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        /* Pagination personnalisée */
        div.dataTables_paginate a {
            background-color: #2563eb;
            color: #fff !important;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        div.dataTables_paginate a:hover {
            background-color: #1d4ed8;
        }

        div.dataTables_paginate .current,
        div.dataTables_paginate .paginate_button.current {
            background-color: #1d4ed8;
            font-weight: 600;
        }

        div.dataTables_wrapper .dataTables_length,
        div.dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px !important;
        }
    </style>

    <!-- Script de recherche dynamique -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('client_search');
            const clientResults = document.getElementById('client_results');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.trim();
                if (query.length < 2) {
                    clientResults.classList.add('hidden');
                    return;
                }

                // Requête AJAX pour récupérer les clients correspondants
                fetch("{{ route('clients.search') }}?query=" + query)
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
                                clientResults.classList.add('hidden');
                            });

                            clientResults.appendChild(li);
                        });
                    })
                    .catch(error => {
                        console.error('Erreur AJAX:', error);
                    });
            });
        });
    </script>
@endsection
