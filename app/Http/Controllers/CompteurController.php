<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compteur;

class CompteurController extends Controller
{
    public function index()
    {
        $compteurs = Compteur::all();
        return view('compteurs.index', compact('compteurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id',
            'numero' => 'required|string|max:255',
            'nouvel_index' => 'required|numeric',
            'date_compteur' => 'required|date',
        ]);

        $compteur = Compteur::create($validated);
        return response()->json(['success' => true, 'compteur' => $compteur]);
    }

    public function update(Request $request, Compteur $compteur)
    {
        $validated = $request->validate([
            'id_client' => 'required|exists:clients,id',
            'numero' => 'required|string|max:255',
            'nouvel_index' => 'required|numeric',
            'date_compteur' => 'required|date',
        ]);

        $compteur->update($validated);
        return response()->json(['success' => true, 'compteur' => $compteur]);
    }

    public function destroy(Compteur $compteur)
    {
        $compteur->delete();
        return response()->json(['success' => true]);
    }
}
