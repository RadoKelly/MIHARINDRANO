@extends('layouts.app')
@section('navbar')
    @include('navbar')
@endsection
@section('content')
<div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Relevé Consommations Clients</h1>
        <div class="flex mt-4 sm:mt-0 space-x-3">
            <a href="{{ route('sites.compteur.create', $site) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Ajouter un Relevé
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">N° Référence</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Nom Client</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Date du Relevé</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Ancienne Date</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">N° Facture</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Tarif</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Ancien Index</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Nouvel Index</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Consommation</th>
                    <th class="p-2 sm:p-3 text-center text-xs sm:text-sm font-medium uppercase tracking-wider truncate border border-blue-800">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($compteurs as $compteur)
                    <tr>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->id }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->client->nom }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->date_releve }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->ancien_date }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->numero_facture }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->tarif->nom }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->ancien_index }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->nouvel_index }}</td>
                        <td class="p-2 sm:p-3 text-center">{{ $compteur->consommation }}</td>
                        <td class="p-2 sm:p-3 text-center">
                            <!-- Ajoutez vos actions ici, par exemple Modifier, Supprimer -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
