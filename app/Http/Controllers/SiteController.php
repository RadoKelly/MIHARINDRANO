<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::all(); // Récupérer tous les sites
        return view('sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero_site' => 'required|string|max:255',
            'nom_site' => 'required|string|max:255',
            'technologie' => 'required|string|max:255',
            'etape_avancement' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'date_debut_etape' => 'required|date',
        ]);
    
        Site::create($validatedData); // Créer un nouveau site
    
        return redirect()->route('sites.index')->with('success', 'Site créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Site $site)
    {
        return view('sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Site $site)
    {
        $validatedData = $request->validate([
            'numero_site' => 'required|string|max:255',
            'nom_site' => 'required|string|max:255',
            'technologie' => 'required|string|max:255',
            'etape_avancement' => 'required|string|max:255',
            'responsable' => 'required|string|max:255',
            'date_debut_etape' => 'required|date',
        ]);
    
        $site->update($validatedData); // Mettre à jour le site
    
        return redirect()->route('sites.index')->with('success', 'Site mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Site $site)
    {
        $site->delete(); // Supprimer le site
        return redirect()->route('sites.index')->with('success', 'Site supprimé avec succès!');
    }
}
