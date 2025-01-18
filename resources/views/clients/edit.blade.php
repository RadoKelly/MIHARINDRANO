@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Modifier le Client</h1>

        <form action="{{ route('clients.update',['site' => $site->id,'client' => $client->id]) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nom_client" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="nom_client" id="nom_client" value="{{ $client->nom_client }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="adress_client" class="block text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" name="adress_client" id="adress_client" value="{{ $client->adress_client }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="localite" class="block text-sm font-medium text-gray-700">Localité</label>
                <input type="text" name="localite" id="localite" value="{{ $client->localite }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                <input type="text" name="categorie" id="categorie" value="{{ $client->categorie }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="date_raccordement" class="block text-sm font-medium text-gray-700">Date de raccordement</label>
                <input type="date" name="date_raccordement" id="date_raccordement" value="{{ $client->date_raccordement }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="ref" class="block text-sm font-medium text-gray-700">Référence</label>
                <input type="text" name="ref" id="ref" value="{{ $client->ref }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="id_site" class="block text-sm font-medium text-gray-700">Site</label>
                <select value="{{ $site->id }}" name="id_site" id="id_site" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    
                    <option value="{{ $site->id }}" {{ $site->id == $client->id_site ? 'selected' : '' }}>
                        {{ $site->nom_site }}
                    </option>
                </select>
            </div>

            <!-- Bouton Submit pour enregistrer les modifications -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection