@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
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
                <thead class="bg-gray-50">
                    <tr>
                        <th class="hidden sm:table-cell p-1 sm:p-2 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Numéro Site</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Nom Site</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Technologie</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Étape Avancement</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Responsable</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Date Début Étape</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Loop through sites -->
                    @foreach ($sites as $site)
                        <tr class="hover:bg-gray-50 transition duration-300 border">
                            <td class="hidden sm:table-cell p-1 sm:p-2 text-xs sm:text-sm text-gray-700 truncate overflow-hidden border">{{ $site->numero_site }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->nom_site }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->technologie }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->etape_avancement }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->responsable }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $site->date_debut_etape }}</td>
                            <td class="p-2 sm:p-3 text-sm border">
                                <div class="flex flex-wrap ">
                                    <a href="{{ route('sites.edit', $site) }}" class="text-blue-500 hover:text-blue-700 mr-2 py-1 px-2 w-full sm:w-auto border">
                                        Modifier
                                    </a>
                                    <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline">
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