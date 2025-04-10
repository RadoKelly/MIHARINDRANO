<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Compteur;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


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

    public function store(Request $request, Site $site)
    {
        // Récupérer le dernier relevé pour le client sur ce site
        $dernierReleve = Compteur::where('client_id', $request->client_id)
            ->where('site_id', $site->id)
            ->orderBy('date_releve', 'desc')
            ->first();

        // Validation des données du formulaire
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_releve' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($dernierReleve) {
                    if ($dernierReleve && $value <= $dernierReleve->date_releve) {
                        $fail("La date du relevé doit être postérieure à la dernière date de relevé ({$dernierReleve->date_releve->format('d/m/Y')}).");
                    }
                }
            ],
            'nouvel_index' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($dernierReleve) {
                    if ($dernierReleve && $value <= $dernierReleve->nouvel_index) {
                        $fail("Le nouvel index doit être supérieur à l'index précédent ({$dernierReleve->nouvel_index}).");
                    }
                }
            ],
            'tarif_id' => 'nullable',
        ]);

        // Déterminer l'ancien index
        $ancien_index = $dernierReleve ? $dernierReleve->nouvel_index : 0;

        // Calcul consommation
        $consommation = $request->nouvel_index - $ancien_index;

        // Génération du numéro de facture
        $prefix = str_pad($site->numero_site, 3, '0', STR_PAD_LEFT);
        $yearMonth = \Carbon\Carbon::parse($request->date_releve)->format('Ym');
        $increment = Compteur::where('client_id', $request->client_id)->count() + 1;
        $incrementFormatted = str_pad($increment, 3, '0', STR_PAD_LEFT);
        $numero_facture_auto = "{$prefix} {$incrementFormatted} {$yearMonth}";

        $frais_compteur = 500;

        // Récupérer le client et son tarif associé
        $client = \App\Models\Client::findOrFail($request->client_id);
        $tarif = $client->tarif;

        $prix_par_index = $consommation * $tarif->pu_m3_unique;
        $prix_total = $prix_par_index + $frais_compteur;

        // Création du nouveau compteur
        Compteur::create([
            'site_id' => $site->id,
            'client_id' => $request->client_id,
            'date_releve' => $request->date_releve,
            'ancien_date' => $dernierReleve ? $dernierReleve->date_releve : null,
            'numero_facture' => $numero_facture_auto,
            'tarif_id' => $request->tarif_id,
            'ancien_index' => $ancien_index,
            'nouvel_index' => $request->nouvel_index,
            'consommation' => $consommation,
            'frais_compteur' => $frais_compteur,
            'prix_par_index' => $prix_par_index,
            'prix_total' => $prix_total,
        ]);


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
            'date_releve' => 'required|date',
            'nouveau_index' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        // Calcul de la consommation basée sur la différence entre l'**ancien index** et le **nouveau index**
        // On calcule la consommation à partir de l'ancien index, indépendamment de si le nouveau index est plus petit ou plus grand.
        $calculConsommation = $request->nouveau_index - $compteur->ancien_index;

        // Mise à jour du relevé existant
        $compteur->update([
            // Mise à jour de la date du relevé
            'date_releve'   => $request->date_releve,
            // L'**ancien index** reste inchangé
            'ancien_index'  => $compteur->ancien_index,  // Ne pas modifier l'ancien index
            // Mise à jour du **nouvel index** avec la valeur du formulaire
            'nouvel_index'  => $request->nouveau_index,
            // La consommation est recalculée en fonction de l'**ancien index**
            'consommation'  => $calculConsommation,
        ]);

        // Si tu as une soumission AJAX, retourne une réponse JSON pour mettre à jour la ligne dans le tableau
        // return response()->json($compteur);

        // Redirection vers l'index avec un message de succès
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


    // Dans ton contrôleur CompteurController.php

    public function getFilteredCompteurs(Request $request)
    {
        $compteurs = Compteur::query();

        if ($request->has('year')) {
            $compteurs->whereYear('date_releve', $request->year);
        }

        if ($request->has('month')) {
            $compteurs->whereMonth('date_releve', $request->month);
        }

        $compteurs = $compteurs->get();

        return response()->json($compteurs);
    }
}
