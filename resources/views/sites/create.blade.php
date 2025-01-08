@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <h1 class="text-2xl font-bold mb-4">Créer un nouveau site</h1>
        <form action="{{ route('sites.store') }}" method="POST" class="bg-white p-8 rounded shadow-md space-y-4">
            @csrf
            <div class="mb-4">
                <label for="numero_site" class="block text-gray-700 text-sm font-bold mb-2">Numéro Site:</label>
                <input type="text" name="numero_site" id="numero_site" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('numero_site')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="nom_site" class="block text-gray-700 text-sm font-bold mb-2">Nom Site:</label>
                <input type="text" name="nom_site" id="nom_site" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('nom_site')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="technologie" class="block text-gray-700 text-sm font-bold mb-2">Technologie:</label>
                <input type="text" name="technologie" id="technologie" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('technologie')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="etape_avancement" class="block text-gray-700 text-sm font-bold mb-2">Étape Avancement:</label>
                <input type="text" name="etape_avancement" id="etape_avancement" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('etape_avancement')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="responsable" class="block text-gray-700 text-sm font-bold mb-2">Responsable:</label>
                <input type="text" name="responsable" id="responsable" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('responsable')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="date_debut_etape" class="block text-gray-700 text-sm font-bold mb-2">Date Début Étape:</label>
                <input type="date" name="date_debut_etape" id="date_debut_etape" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                @error('date_debut_etape')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Créer</button>
            </div>
        </form>
    </div>
@endsection