@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 sm:px-6 md:px-8 pt-24 ml-16">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Liste des Clients</h1>
            <a href="{{ route('clients.create', ['site' => $site->id]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un Client
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- TABLEAU pour Desktop uniquement --}}
        <div class="overflow-x-auto py-4 hidden lg:block">
            <table id="clients-table" class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-white uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-2 text-center">ID</th>
                        <th class="px-4 py-2">Nom</th>
                        <th class="px-4 py-2">Adresse</th>
                        <th class="px-4 py-2">Localité</th>
                        <th class="px-4 py-2">Catégorie</th>
                        <th class="px-4 py-2">Réf</th>
                        <th class="px-4 py-2">Compteur</th>
                        <th class="px-4 py-2">Site</th>
                        <th class="px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($clients as $client)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-2 text-center font-medium text-gray-800">{{ $client->id }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->nom_client }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->adress_client }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->localite }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->categorie }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->ref }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->numero_compteur }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $client->site->nom_site }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-4">
                                    <a href="{{ route('clients.edit', ['site' => $site->id, 'client' => $client->id]) }}"
                                        class="text-yellow-500 hover:text-yellow-600 transition" title="Modifier">
                                         <i class="fas fa-pen-to-square"></i>
                                     </a>
                                    <form action="{{ route('clients.destroy', ['site' => $site->id, 'client' => $client->id]) }}"
                                          method="POST" onsubmit="return confirm('Supprimer ce client ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

{{-- CARTES pour Mobile & Tablette (lg:hidden) --}}
<div class="grid lg:hidden grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
    @foreach ($clients as $client)
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition duration-300">
            <h3 class="text-lg font-semibold text-gray-900 break-words leading-snug mb-1">
                {{ $client->nom_client }}
            </h3>
            <div class="text-sm text-gray-600 space-y-1">
                <p><span class="font-medium">📍 Adresse :</span> {{ $client->adress_client }}</p>
                <p><span class="font-medium">🏘️ Localité :</span> {{ $client->localite }}</p>
                <p><span class="font-medium">🏷️ Catégorie :</span> {{ $client->categorie }}</p>
                <p><span class="font-medium">🆔 Réf :</span> {{ $client->ref }}</p>
                <p><span class="font-medium">🔢 Compteur :</span> {{ $client->numero_compteur }}</p>
                <p><span class="font-medium">📌 Site :</span> {{ $client->site->nom_site }}</p>
            </div>

            <div class="flex justify-end items-center space-x-4 mt-4">
                <a href="{{ route('clients.edit', ['site' => $site->id, 'client' => $client->id]) }}"
                    class="text-yellow-500 hover:text-yellow-600 transition" title="Modifier">
                    <i class="fas fa-pen-to-square text-lg"></i>
                </a>
                <form action="{{ route('clients.destroy', ['site' => $site->id, 'client' => $client->id]) }}"
                    method="POST" onsubmit="return confirm('Supprimer ce client ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600 transition" title="Supprimer">
                        <i class="fas fa-trash text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>


    <!-- Scripts DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#clients-table').DataTable({
                language: {
                    search: "🔍 Rechercher :",
                    lengthMenu: "Afficher _MENU_ entrées",
                    zeroRecords: "Aucun résultat",
                    info: "Page _PAGE_ sur _PAGES_",
                    infoEmpty: "Aucun client trouvé",
                    infoFiltered: "(filtré de _MAX_ clients)",
                    paginate: {
                        next: "Suivant",
                        previous: "Précédent"
                    }
                }
            });
        });
    </script>

    <style>
        /* Espacement entre les contrôles DataTables */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.5rem;
        }

        .dataTables_wrapper .dataTables_info {
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.5rem;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
        }

        .dataTables_paginate a {
            padding: 8px 12px;
            margin: 0 4px;
            border-radius: 6px;
            background-color: #2563eb;
            color: white !important;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dataTables_paginate a:hover {
            background-color: #1d4ed8;
        }

        .dataTables_paginate .current {
            background-color: #1d4ed8 !important;
            font-weight: bold;
        }
    </style>
@endsection
