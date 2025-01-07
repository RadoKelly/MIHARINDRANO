@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Liste des Sites</h1>

        <!-- Tableau des sites -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro Site</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Site</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technologie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étape Avancement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsable</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Début Étape</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Boucle pour afficher les sites dynamiquement -->
                    @foreach ($sites as $site)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->numero_site }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->nom_site }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->technologie }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->etape_avancement }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->responsable }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $site->date_debut_etape }}</td>
                            <td class="px-6 py-4 text-sm">
                                <!-- Bouton Modifier avec texte -->
                                <a href="{{ route('sites.edit', $site) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                    Modifier
                                </a>
                                <!-- Bouton Supprimer avec texte -->
                                <form action="{{ route('sites.destroy', $site) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection