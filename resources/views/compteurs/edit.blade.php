@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Modifier le Relevé de Compteur</h1>

    <form action="{{ route('sites.compteur.update', ['site' => $site->id, 'compteur' => $compteur->id]) }}" method="POST">
        @csrf
        @method('PUT') <!-- Utilise la méthode PUT pour la mise à jour -->

        <div class="space-y-4">
            <!-- Champ Client -->
            <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select name="client_id" id="client_id" class="mt-1 block w-full">
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $compteur->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->nom_client }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Champ Date Relevé -->
            <div>
                <label for="date_releve" class="block text-sm font-medium text-gray-700">Date du Relevé</label>
                <input type="date" name="date_releve" id="date_releve" value="{{ $compteur->date_releve }}" class="mt-1 block w-full">
            </div>

            <!-- Champ Nouvel Index -->
            <div>
                <label for="nouvel_index" class="block text-sm font-medium text-gray-700">Nouvel Index</label>
                <input type="number" name="nouvel_index" id="nouvel_index" value="{{ $compteur->nouvel_index }}" class="mt-1 block w-full">
            </div>

            <!-- Champ Tarif -->
            

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('compteur.index', $site) }}" class="px-4 py-2 bg-gray-300 text-white rounded">Annuler</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Mettre à jour</button>
            </div>
        </div>
    </form>
</div>
@endsection
