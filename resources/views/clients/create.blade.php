@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <h1 class="text-2xl font-bold mb-4">Ajouter un Client</h1>
        <form action="{{ route('clients.store') }}" method="POST" class="bg-white p-8 rounded shadow-md space-y-4">
            @csrf

            <div class="mb-4">
                <label for="nom_client" class="block text-gray-700 text-sm font-bold mb-2">Nom:</label>
                <input type="text" name="nom_client" id="nom_client" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="adress_client" class="block text-gray-700 text-sm font-bold mb-2">Adresse:</label>
                <input type="text" name="adress_client" id="adress_client" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="localite" class="block text-gray-700 text-sm font-bold mb-2">Localité:</label>
                <input type="text" name="localite" id="localite" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="categorie" class="block text-gray-700 text-sm font-bold mb-2">Catégorie:</label>
                <input type="text" name="categorie" id="categorie" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="date_raccordement" class="block text-gray-700 text-sm font-bold mb-2">Date de raccordement:</label>
                <input type="date" name="date_raccordement" id="date_raccordement" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="ref" class="block text-gray-700 text-sm font-bold mb-2">Référence:</label>
                <input type="text" name="ref" id="ref" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
            </div>

            <div class="mb-4">
                <label for="id_site" class="block text-gray-700 text-sm font-bold mb-2">Site:</label>
                <select name="id_site" id="id_site" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    @foreach($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->nom_site }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ajouter</button>
            </div>
        </form>
    </div>
@endsection