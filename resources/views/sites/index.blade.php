@extends('layouts.app')

@section('navbar')
    
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 ml-16">
        <!-- Flex container for heading and button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Liste des Sites</h1>
            <a href="{{ route('sites.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0" aria-label="Créer un nouveau site">
                Nouveau Site
            </a>
        </div>

        <!-- Responsive table container -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="hidden sm:table-cell p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Numéro Site</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Nom Site</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Technologie</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Étape Avancement</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Responsable</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Date Début Étape</th>
                        <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Loop through sites -->
                    @foreach ($sites as $site)
                        <tr class="hover:bg-gray-50 transition duration-300 border">
                            <td class="hidden sm:table-cell p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->numero_site }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->nom_site }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->technologie }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->etape_avancement }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->responsable }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->date_debut_etape }}</td>
                            <td class="p-2 sm:p-3 text-sm border">
                                <div class="flex flex-wrap justify-center">
                                    <a href="{{ route('sites.edit', $site) }}" class="text-yellow-500 hover:text-yellow-700 mr-2 py-1 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('clients.index', ['site' => $site->id]) }}" class="text-blue-500 hover:text-blue-700 mr-2 py-1 px-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline">
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