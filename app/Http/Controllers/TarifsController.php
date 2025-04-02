<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use App\Models\Site;

class TarifsController extends Controller
{
    /**
     * Affiche la liste des tarifs pour un site donné.
     */
    public function index(Site $site)
    {
        $tarifs = Tarif::where('site_id', $site->id)->orderBy('date', 'desc')->get();
        return view('tarifs.index', compact('tarifs', 'site'));
    }
    
    /**
     * Affiche le formulaire de création d'un nouveau tarif.
     */
    public function create(Site $site)
    {
        return view('tarifs.create', compact('site'));
    }

    /**
     * Enregistre un nouveau tarif dans la base de données.
     */
    public function store(Request $request, Site $site)
    {
        $request->validate([
            'nom_tarif'         => 'required|string|max:255',
            'location_compteur' => 'required|string|max:255',
            'pu_m3_unique'      => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'site_id'           => $site->id,
            'date'              => now(), // Date automatique
            'nom_tarif'         => $request->nom_tarif,
            'location_compteur' => $request->location_compteur,
            'pu_m3_unique'      => $request->pu_m3_unique,
        ]);

        return redirect()->route('tarifs.index', ['site' => $site->id])
            ->with('success', 'Tarif ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un tarif existant.
     */
    public function edit(Site $site, Tarif $tarif)
    {
        return view('tarifs.edit', compact('tarif', 'site'));
    }

    /**
     * Met à jour un tarif existant.
     */
    public function update(Request $request, Site $site, Tarif $tarif)
    {
        $request->validate([
            'nom_tarif'         => 'required|string|max:255',
            'location_compteur' => 'required|string|max:255',
            'pu_m3_unique'      => 'required|numeric|min:0',
        ]);

        $tarif->update([
            'nom_tarif'         => $request->nom_tarif,
            'location_compteur' => $request->location_compteur,
            'pu_m3_unique'      => $request->pu_m3_unique,
        ]);

        return redirect()->route('tarifs.index', ['site' => $site->id])
            ->with('success', 'Tarif mis à jour avec succès.');
    }

    /**
     * Supprime un tarif.
     */
    public function destroy(Site $site, Tarif $tarif)
    {
        $tarif->delete();
        return redirect()->route('tarifs.index', ['site' => $site->id])
            ->with('success', 'Tarif supprimé avec succès.');
    }
}