@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 ml-16">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Liste des Clients</h1>
            <a href="{{ route('clients.create', ['site' => $site->id]) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0"
                aria-label="Ajouter un Client">
                Ajouter un Client
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="clients-table" class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg">
                <thead class="bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Nom</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Adresse
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Localité
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Catégorie</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Référence</th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Site
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($clients as $client)
                        <tr class="hover:bg-blue-50 transition duration-300">
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->nom_client }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->adress_client }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->localite }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->categorie }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->ref }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center">{{ $client->site->nom_site }}</td>
                            <td class="px-4 py-2 text-sm text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('clients.edit', ['site' => $site->id, 'client' => $client->id]) }}"
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <!-- Icone d'édition -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form
                                        action="{{ route('clients.destroy', ['site' => $site->id, 'client' => $client->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <!-- Icone de suppression -->
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

    <!-- Styles personnalisés pour DataTables -->
    <style>
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
@endsection
