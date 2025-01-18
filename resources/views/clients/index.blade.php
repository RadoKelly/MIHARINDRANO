@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <!-- Flex container for heading and button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Liste des Clients</h1>
            <a href="{{ route('clients.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0" aria-label="Ajouter un Client">
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
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">ID</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Nom</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Adresse</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Localité</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Catégorie</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Référence</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Site</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Actions</th>
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
                                <div class="flex flex-wrap">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2 py-1 px-2 w-full sm:w-auto border">
                                        Modifier
                                    </a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 py-1 px-2 w-full sm:w-auto border">
                                            Supprimer
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