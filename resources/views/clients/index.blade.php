@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 ml-16">
        <!-- Flex container for heading and button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Liste des Clients</h1>
            <a href="{{ route('clients.create', ['site' => $site->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0" aria-label="Ajouter un Client">
                Ajouter un Client
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Responsive table container -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">ID</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Nom</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Adresse</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Localité</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Catégorie</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Référence</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Site</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-50 transition duration-300 border">
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->id }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->nom_client }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->adress_client }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->localite }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->categorie }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->ref }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->site->nom_site }}</td>
                            <td class="p-2 sm:p-3 text-sm border">
                                <div class="flex flex-wrap justify-center">
                                    <a href="{{ route('clients.edit', ['site' => $site->id, 'client' => $client->id]) }}" class="text-yellow-500 hover:text-yellow-700 mr-2 py-1 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('clients.destroy', ['site' => $site->id, 'client' => $client->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 py-1 px-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
@endsection
