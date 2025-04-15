@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <h1 class="text-2xl font-bold mb-4">Créer un nouveau site</h1>
        <form action="{{ route('sites.store') }}" method="POST" class="bg-white p-8 rounded shadow-md space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="numero_site" class="block text-gray-700 text-sm font-bold mb-2">Numéro Site:</label>
                    <input type="text" name="numero_site" id="numero_site" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('numero_site')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nom_site" class="block text-gray-700 text-sm font-bold mb-2">Nom Site:</label>
                    <input type="text" name="nom_site" id="nom_site" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('nom_site')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="technologie" class="block text-gray-700 text-sm font-bold mb-2">Technologie:</label>
                    <input type="text" name="technologie" id="technologie" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('technologie')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="etape_avancement" class="block text-gray-700 text-sm font-bold mb-2">Étape Avancement:</label>
                    <input type="text" name="etape_avancement" id="etape_avancement" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('etape_avancement')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="responsable" class="block text-gray-700 text-sm font-bold mb-2">Responsable:</label>
                    <input type="text" name="responsable" id="responsable" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('responsable')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="date_debut_etape" class="block text-gray-700 text-sm font-bold mb-2">Date Début Étape:</label>
                    <input type="date" name="date_debut_etape" id="date_debut_etape" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    @error('date_debut_etape')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Créer</button>
                </div>
            </div>
        </form>
    </div>
@endsection