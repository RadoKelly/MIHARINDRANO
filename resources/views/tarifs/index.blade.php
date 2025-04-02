@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8 ml-16">
        <!-- Titre de la page -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Gestion des Tarifs</h1>
        </div>

        <!-- Formulaire d'ajout de tarif -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-8">
            <h2 class="text-xl font-bold mb-4">Ajouter un Tarif</h2>
            @if ($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                           <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('tarifs.store', ['site' => $site->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="site_id" value="{{ $site->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date (générée automatiquement) -->
                    <div>
                        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                        <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" readonly
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Nom Tarif -->
                    <div>
                        <label for="nom_tarif" class="block text-gray-700 text-sm font-bold mb-2">Nom Tarif</label>
                        <input type="text" id="nom_tarif" name="nom_tarif" placeholder="Nom du tarif"
                               value="{{ old('nom_tarif') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Location Compteur -->
                    <div>
                        <label for="location_compteur" class="block text-gray-700 text-sm font-bold mb-2">Location Compteur</label>
                        <input type="text" id="location_compteur" name="location_compteur" placeholder="Location compteur"
                               value="{{ old('location_compteur') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- PU m3 Unique -->
                    <div>
                        <label for="pu_m3_unique" class="block text-gray-700 text-sm font-bold mb-2">PU m3 Unique</label>
                        <input type="text" id="pu_m3_unique" name="pu_m3_unique" placeholder="Prix unitaire m3 unique"
                               value="{{ old('pu_m3_unique') }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des tarifs enregistrés -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
            <h2 class="text-xl font-bold mb-4">Liste des Tarifs</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="p-2 sm:p-3 border border-blue-800">Date</th>
                            <th class="p-2 sm:p-3 border border-blue-800">Nom Tarif</th>
                            <th class="p-2 sm:p-3 border border-blue-800">Location Compteur</th>
                            <th class="p-2 sm:p-3 border border-blue-800">PU m3 Unique</th>
                            <th class="p-2 sm:p-3 border border-blue-800">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tarifs as $tarif)
                            <tr>
                                <td class="p-2 sm:p-3 border">{{ \Carbon\Carbon::parse($tarif->date)->format('d/m/Y') }}</td>
                                <td class="p-2 sm:p-3 border">{{ $tarif->nom_tarif }}</td>
                                <td class="p-2 sm:p-3 border">{{ $tarif->location_compteur }} Ar</td>
                                <td class="p-2 sm:p-3 border">{{ number_format($tarif->pu_m3_unique, 2, ',', ' ') }} Ar</td>
                                <td class="p-2 sm:p-3 border flex space-x-2">
                                    <!-- Modifier -->
                                    <button onclick="openEditModal({{ $tarif->id }}, '{{ $tarif->date }}', '{{ $tarif->nom_tarif }}', '{{ $tarif->location_compteur }}', '{{ $tarif->pu_m3_unique }}')"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold w-8 h-8 flex items-center justify-center rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                
                                    <!-- Supprimer -->
                                    <form action="{{ route('tarifs.destroy', ['site' => $site->id, 'tarif' => $tarif->id]) }}" method="POST"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce tarif ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 flex items-center justify-center rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-2 sm:p-3 border text-center">Aucun tarif enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modale d'édition -->
        <div id="editModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Modifier un Tarif</h2>
                <form id="editForm" method="POST" action="{{ route('tarifs.update', ['site' => $site->id, 'tarif' => 0]) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="site_id" value="{{ $site->id }}">
                    <input type="hidden" name="tarif_id" id="editTarifId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                            <input type="date" id="editDate" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="nom_tarif" class="block text-gray-700 text-sm font-bold mb-2">Nom Tarif</label>
                            <input type="text" id="editNomTarif" name="nom_tarif" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="location_compteur" class="block text-gray-700 text-sm font-bold mb-2">Location Compteur</label>
                            <input type="text" id="editLocationCompteur" name="location_compteur" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="pu_m3_unique" class="block text-gray-700 text-sm font-bold mb-2">PU m3 Unique</label>
                            <input type="text" id="editPUM3Unique" name="pu_m3_unique" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
                <button onclick="closeEditModal()" class="absolute top-0 right-0 p-2 text-white">X</button>
            </div>
        </div>
    </div>

    </div>

    <script>
        function openEditModal(tarifId, date, nomTarif, locationCompteur, puM3Unique) {
            // Afficher le modale
            document.getElementById("editModal").classList.remove("hidden");
            // Remplir le formulaire avec les données existantes
            document.getElementById("editTarifId").value = tarifId;
            document.getElementById("editDate").value = date;
            document.getElementById("editNomTarif").value = nomTarif;
            document.getElementById("editLocationCompteur").value = locationCompteur;
            document.getElementById("editPUM3Unique").value = puM3Unique;
            // Mettre à jour l'URL du formulaire d'édition
            document.getElementById("editForm").action = "/sites/{{ $site->id }}/tarifs/" + tarifId;
        }

        function closeEditModal() {
            // Cacher le modale
            document.getElementById("editModal").classList.add("hidden");
        }
    </script>
@endsection
