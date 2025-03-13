@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')

<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    {{-- Section Filtres et Pagination --}}
    <div class="flex flex-wrap items-center justify-between mb-4">
        <div class="flex space-x-4">
            <div>
                <label class="text-gray-700 font-semibold">Année:</label>
                <select class="border border-gray-300 rounded-lg p-2">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                </select>
            </div>
            <div>
                <label class="text-gray-700 font-semibold">Mois:</label>
                <select class="border border-gray-300 rounded-lg p-2">
                    <option>(a)- Janvier</option>
                    <option>(b)- Février</option>
                    <option>(c)- Mars</option>
                </select>
            </div>
        </div>
        
        <div class="flex space-x-2">
            <button class="bg-gray-300 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-400">
                Première période
            </button>
            <button class="bg-gray-300 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-400">
                Période précédente
            </button>
            <button class="bg-gray-300 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-400">
                Période suivante
            </button>
            <button class="bg-gray-300 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-400">
                Dernière période
            </button>
        </div>
    </div>

    {{-- Bouton Ajouter --}}
    <div class="flex justify-end mb-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Ajouter consommation
        </button>
    </div>

    {{-- Table des consommations --}}
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="px-4 py-2">N° Mois</th>
                    <th class="px-4 py-2">Catégorie client</th>
                    <th class="px-4 py-2">Tarif</th>
                    <th class="px-4 py-2">Nombre abonnés</th>
                    <th class="px-4 py-2">Nombre ménages</th>
                    <th class="px-4 py-2">Consommation < 10m³</th>
                    <th class="px-4 py-2">Consommation > 10m³</th>
                    <th class="px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody class="bg-white text-gray-800">
                <tr class="border-t border-gray-300">
                    <td class="px-4 py-2">Janvier</td>
                    <td class="px-4 py-2">Résidentiel</td>
                    <td class="px-4 py-2">Standard</td>
                    <td class="px-4 py-2">150</td>
                    <td class="px-4 py-2">80</td>
                    <td class="px-4 py-2">500 m³</td>
                    <td class="px-4 py-2">300 m³</td>
                    <td class="px-4 py-2">800 m³</td>
                </tr>
                <tr class="border-t border-gray-300">
                    <td class="px-4 py-2">Février</td>
                    <td class="px-4 py-2">Commercial</td>
                    <td class="px-4 py-2">Premium</td>
                    <td class="px-4 py-2">100</td>
                    <td class="px-4 py-2">50</td>
                    <td class="px-4 py-2">400 m³</td>
                    <td class="px-4 py-2">350 m³</td>
                    <td class="px-4 py-2">750 m³</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
