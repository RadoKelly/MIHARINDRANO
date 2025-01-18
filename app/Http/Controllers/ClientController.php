<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('site')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $sites = Site::all();
        return view('clients.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_site' => 'required|exists:sites,id',
            'adress_client' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'categorie' => 'required|string|max:100',
            'date_raccordement' => 'required|date',
            'ref' => 'required|string|unique:clients,ref',
            'nom_client' => 'required|string|max:255',
        ]);

        Client::create($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $sites = Site::all();
        return view('clients.edit', compact('client', 'sites'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validatedData = $request->validate([
            'id_site' => 'required|exists:sites,id',
            'adress_client' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'categorie' => 'required|string|max:100',
            'date_raccordement' => 'required|date',
            'ref' => 'required|string|unique:clients,ref,' . $id,
            'nom_client' => 'required|string|max:255',
        ]);

        $client->update($validatedData);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
    public function getCompteurs(Client $client)
    {
        return response()->json([
            'compteurs' => $client->compteurs
        ]);
    }
}
