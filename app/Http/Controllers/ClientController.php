<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        $clients = Client::where('nom_client', 'like', '%' . $query . '%')->limit(10)->get(['id', 'nom_client', 'tarif_id']);

        return response()->json($clients);
    }

    public function getclients(Site $site)
    {
        $clients = Client::with('site')->get();
        return view('clients.index', compact('clients'), ['site' => $site]);
    }
    public function index(Site $site)
    {
        $clients = Client::where('id_site', $site->id)->with('site')->get();
        return view('clients.index', compact('clients', 'site'));
    }

    public function create(Site $site)
    {
        return view('clients.create', compact('site'));
    }

    public function store(Site $site, Request $request)
    {
        $validatedData = $request->validate([
            'id_site' => 'required|exists:sites,id',
            'adress_client' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'categorie' => 'required|string|max:100',
            'date_raccordement' => 'required|date',
            'ref' => 'required|string|unique:clients,ref',
            'nom_client' => 'required|string|max:255',
            'frais_raccordement' => 'required|numeric|min:0',
            'numero_compteur' => 'required|string|max:255',
        ]);
    
        // Déterminer le tarif en fonction de la catégorie
        $tarifs = [
            'kiosque_eau' => 1,
            'branchements_partages' => 2,
            'branchements_privés' => 3,
            'equivalents_service_public' => 4,
        ];
    
        $categorie = $request->input('categorie');
        $tarifId = $tarifs[$categorie] ?? null;  // Si catégorie non trouvée, tarif_id sera null
    
        $validatedData['tarif_id'] = $tarifId;
    
        // Créer le client avec les données validées
        Client::create($validatedData);
    
        return redirect()->route('clients.index', ['site' => $site->id])
                         ->with('success', 'Client ajouté avec succès.');
    }
    

    public function edit(Site $site, $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client', 'site'));
    }

    public function update(Request $request, Site $site, $id)
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

        $tarifs = [
            'kiosque_eau' => 1,
            'branchements_partages' => 2,
            'branchements_privés' => 3,
            'equivalents_service_public' => 4,
        ];

        // Assigner le tarif en fonction de la catégorie
        $categorie = $request->input('categorie');
        $tarifId = $tarifs[$categorie] ?? null;  // Si catégorie non trouvée, tarif_id sera null

        // Ajouter le tarif_id aux données validées
        $validatedData['tarif_id'] = $tarifId;


        $client->update($validatedData);

        return redirect()->route('clients.index', ['site' => $site->id])->with('success', 'Client mis à jour avec succès.');
    }

    public function destroy(Site $site, $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index', ['site' => $site->id])->with('success', 'Client supprimé avec succès.');
    }
    public function getCompteurs(Client $client)
    {
        return response()->json([
            'compteurs' => $client->compteurs
        ]);
    }
}
