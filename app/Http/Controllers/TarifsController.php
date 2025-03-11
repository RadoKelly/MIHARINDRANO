<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Tarif;

class TarifsController extends Controller
{
    /**
     * Affiche la liste des tarifs pour un site donné.
     */
    public function index(Site $site)
    {
        // Récupérer les tarifs associés au site
        $tarifs = Tarif::where('site_id', $site->id)->get();

        return view('tarifs.index', compact('site', 'tarifs'));
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
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
        ]);

        Tarif::create([
            'site_id' => $site->id,
            'nom' => $request->nom,
            'prix' => $request->prix,
        ]);

        return redirect()->route('tarifs.index', $site)->with('success', 'Tarif ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un tarif existant.
     */
    public function edit(Site $site, Tarif $tarif)
    {
        return view('tarifs.edit', compact('site', 'tarif'));
    }

    /**
     * Met à jour un tarif existant.
     */
    public function update(Request $request, Site $site, Tarif $tarif)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
        ]);

        $tarif->update([
            'nom' => $request->nom,
            'prix' => $request->prix,
        ]);

        return redirect()->route('tarifs.index', $site)->with('success', 'Tarif mis à jour avec succès.');
    }

    /**
     * Supprime un tarif.
     */
    public function destroy(Site $site, Tarif $tarif)
    {
        $tarif->delete();

        return redirect()->route('tarifs.index', $site)->with('success', 'Tarif supprimé avec succès.');
    }
}
