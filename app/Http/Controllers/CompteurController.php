<?php

namespace App\Http\Controllers;

use App\Models\Compteur;
use App\Models\Site;
use Illuminate\Http\Request;

class CompteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Site $site)
    {
        // Récupérer tous les relevés de compteur pour un site donné
        $compteurs = Compteur::where('site_id', $site->id)->get();

        // Retourner la vue avec les données
        return view('compteurs.index', compact('site', 'compteurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Site $site)
    {
        // Charger les clients et les tarifs associés au site
        $clients = $site->clients;
        $tarifs = $site->tarifs;
        return view('compteurs.create', compact('site', 'clients', 'tarifs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Site $site)
    {
        // dd($request->all());
        // Validation des données du formulaire
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_releve' => 'required|date',
            'numero_facture' => 'required|string|max:255',
            'nouvel_index' => 'required|numeric|min:0',
            // 'tarif_id' => 'required|exists:tarifs,id',
        ]);

        

        // Créer un nouveau relevé
            Compteur::create([
            'site_id' => $site->id,
            'client_id' => $request->client_id,
            'date_releve' => $request->date_releve,
            'ancien_date' => now()->subMonth(), // Exemple : ancienne date = 1 mois avant
            'numero_facture' => $request->numero_facture,
            'tarif_id' => $request->tarif_id,
            'ancien_index' => 0, // À remplacer par la logique correcte
            'nouvel_index' => $request->nouvel_index,
            'consommation' => $request->nouvel_index - 0, // À ajuster selon l'ancien index
        ]);

        

        // Rediriger vers le relevé ajouté
        return redirect()->route('compteurs.show', [$site])
            ->with('success', 'Relevé ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site, Compteur $compteur)
    {
        return view('compteurs.show', compact('site', 'compteur'));
    }
}
