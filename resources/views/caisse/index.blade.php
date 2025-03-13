@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')

<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Paiement des factures</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Saisie paiement
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="px-4 py-2">N° Référence</th>
                    <th class="px-4 py-2">Nom client</th>
                    <th class="px-4 py-2">Année</th>
                    <th class="px-4 py-2">Mois</th>
                    <th class="px-4 py-2">N° facture</th>
                    <th class="px-4 py-2">Consommation</th>
                </tr>
            </thead>
            <tbody class="bg-white text-gray-800">
                <tr class="border-t border-gray-300">
                    <td class="px-4 py-2">001</td>
                    <td class="px-4 py-2">Jean Dupont</td>
                    <td class="px-4 py-2">2024</td>
                    <td class="px-4 py-2">Janvier</td>
                    <td class="px-4 py-2">F-2024-001</td>
                    <td class="px-4 py-2">10 m³</td>
                </tr>
                <tr class="border-t border-gray-300">
                    <td class="px-4 py-2">002</td>
                    <td class="px-4 py-2">Marie Curie</td>
                    <td class="px-4 py-2">2024</td>
                    <td class="px-4 py-2">Janvier</td>
                    <td class="px-4 py-2">F-2024-002</td>
                    <td class="px-4 py-2">15 m³</td>
                </tr>
                <tr class="border-t border-gray-300">
                    <td class="px-4 py-2">003</td>
                    <td class="px-4 py-2">Albert Einstein</td>
                    <td class="px-4 py-2">2024</td>
                    <td class="px-4 py-2">Janvier</td>
                    <td class="px-4 py-2">F-2024-003</td>
                    <td class="px-4 py-2">20 m³</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
