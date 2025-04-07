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

        $compteurs->load('client');

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
            'nouvel_index' => 'required|numeric|min:0',
            'tarif_id' => 'nullable',
        ]);

        // Récupérer le dernier relevé pour le client
        $dernierReleve = Compteur::where('client_id', $request->client_id)
            ->where('site_id', $site->id)
            ->orderBy('date_releve', 'desc')
            ->first();

        // Déterminer l'ancien index pour le calcul de la consommation
        $ancien_index = $dernierReleve ? $dernierReleve->nouvel_index : 0;

        // Calcul de la consommation
        $consommation = $request->nouvel_index - $ancien_index;

        // Étape 1 : Construire le préfixe (numéro du site)
        $prefix = str_pad($site->numero_site, 3, '0', STR_PAD_LEFT); // Assure que le numéro du site est toujours sur 3 chiffres

        // Étape 2 : Extraire l'année et le mois du relevé (utiliser la date du relevé envoyée dans la requête)
        $releveDate = $request->date_releve; // La date du relevé envoyée par le formulaire
        $yearMonth = \Carbon\Carbon::parse($releveDate)->format('Ym'); // Formate la date au format "YYYYMM"

        // Étape 3 : Calculer l'incrément pour le client donné
        $increment = Compteur::where('client_id', $request->client_id) // Trouve tous les relevés pour ce client
            ->count() + 1; // Incrémentation par rapport au nombre de relevés déjà existants

        $incrementFormatted = str_pad($increment, 3, '0', STR_PAD_LEFT);  // Formatage de l'incrément avec 3 chiffres

        // Étape 4 : Générer le numéro de facture final
        $numero_facture_auto = "{$prefix} {$incrementFormatted} {$yearMonth}";


        // dd($ancien_index, $request->nouvel_index, $consommation);

        // Enregistrer le nouveau relevé de compteur
        Compteur::create([
            'site_id' => $site->id,
            'client_id' => $request->client_id,
            'date_releve' => $request->date_releve,
            'ancien_date' => now()->subMonth(),  // Exemple : 1 mois avant
            'numero_facture' => $numero_facture_auto,
            'tarif_id' => $request->tarif_id,
            'ancien_index' => $ancien_index,  // L'ancien index est celui du dernier relevé
            'nouvel_index' => $request->nouvel_index,
            'consommation' => $consommation,  // La consommation est calculée ici
        ]);

        // Si le relevé a bien été ajouté, rediriger vers la liste des relevés
        return redirect()->route('compteur.index', [$site])
            ->with('success', 'Relevé ajouté avec succès.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Site $site, Compteur $compteur)
    {
        return view('compteurs.show', compact('site', 'compteur'));
    }

    public function update(Request $request, Site $site, Compteur $compteur)
{
    // Validation des données envoyées par le formulaire
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date_releve' => 'required|date',
        'nouvel_index' => 'required|numeric|min:0',
        
    ]);

    // Mettre à jour les champs du relevé
    $compteur->update([
        'client_id' => $request->client_id,
        'date_releve' => $request->date_releve,
        'ancien_date' => now()->subMonth(),  // Exemple : 1 mois avant
        // 'tarif_id' => $request->tarif_id,
        'ancien_index' => $compteur->nouvel_index, // L'ancien index est celui du dernier relevé
        'nouvel_index' => $request->nouvel_index,
        'consommation' => $request->nouvel_index - $compteur->nouvel_index, // Calcul de la consommation
    ]);

    // Rediriger avec un message de succès
    return redirect()->route('compteur.index', $site)->with('success', 'Relevé mis à jour avec succès.');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site, Compteur $compteur)
    {
        // Charger les clients et les tarifs associés au site
        $clients = $site->clients;
        $tarifs = $site->tarifs;

        // Retourner la vue d'édition avec les données du compteur, clients et tarifs
        return view('compteurs.edit', compact('site', 'compteur', 'clients', 'tarifs'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site, Compteur $compteur)
    {
        // Supprimer le compteur
        $compteur->delete();

        // Rediriger vers la liste des compteurs du site avec un message de succès
        return redirect()->route('compteur.index', $site)
            ->with('success', 'Le relevé de compteur a été supprimé avec succès.');
    }
}
