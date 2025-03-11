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
            <form>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date (générée automatiquement) -->
                    <div>
                        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                        <input type="text" id="date" name="date" value="{{ date('d/m/Y') }}" readonly
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Nom Tarif -->
                    <div>
                        <label for="nom_tarif" class="block text-gray-700 text-sm font-bold mb-2">Nom Tarif</label>
                        <input type="text" id="nom_tarif" name="nom_tarif" placeholder="Nom du tarif"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- Location Compteur -->
                    <div>
                        <label for="location_compteur" class="block text-gray-700 text-sm font-bold mb-2">Location Compteur</label>
                        <input type="text" id="location_compteur" name="location_compteur" placeholder="Location compteur"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <!-- PU m3 Unique -->
                    <div>
                        <label for="pu_m3_unique" class="block text-gray-700 text-sm font-bold mb-2">PU m3 Unique</label>
                        <input type="text" id="pu_m3_unique" name="pu_m3_unique" placeholder="Prix unitaire m3 unique"
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="p-2 sm:p-3 border">01/02/2025</td>
                            <td class="p-2 sm:p-3 border">Tarif Standard</td>
                            <td class="p-2 sm:p-3 border">Local 1</td>
                            <td class="p-2 sm:p-3 border">10,00 €</td>
                        </tr>
                        <tr>
                            <td class="p-2 sm:p-3 border">02/02/2025</td>
                            <td class="p-2 sm:p-3 border">Tarif Premium</td>
                            <td class="p-2 sm:p-3 border">Local 2</td>
                            <td class="p-2 sm:p-3 border">12,50 €</td>
                        </tr>
                        <!-- Vous pouvez ajouter d'autres lignes statiques si besoin -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
