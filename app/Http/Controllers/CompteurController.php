<?php

namespace App\Http\Controllers;

use App\Models\Site;
use GuzzleHttp\Client;
use App\Models\Compteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Exception\RequestException;


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

    public function facture(Site $site, Compteur $compteur)
    {
        // Charger les relations nécessaires
        $compteur->load('client.tarif');

        // Calculer le total et le montant en lettres
        $total = $compteur->prix_total ?? 0;
        $formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
        $montantEnLettres = ucfirst($formatter->format($total)) . ' Ariary';

        // Rendre la vue complète pour extraire le CSS et le fragment
        $fullHtml = View::make('facture.index', compact('site', 'compteur', 'montantEnLettres'))->render();

        // Extraire le contenu des balises <style> du view
        preg_match_all('/<style[^>]*>([\s\S]*?)<\/style>/', $fullHtml, $styleMatches);
        $embeddedCss = '';
        if (!empty($styleMatches[1])) {
            $embeddedCss = implode("\n", $styleMatches[1]);
        }
        // Override pour PDFShift : supprimer fond gris et forcer fond blanc
        $embeddedCss .= "
html, body { background: none !important; margin:0; padding:0;} .page { background: white !important; }";

        // Extraire le fragment #invoice
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($fullHtml, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//*[@id="invoice"]');
        $fragment = $nodes->length ? $dom->saveHTML($nodes->item(0)) : $fullHtml;

        // Construire le HTML minimal avec CSS embarqué
        $html = '<!DOCTYPE html>'
              . '<html><head><meta charset="UTF-8"><style>'
              . $embeddedCss
              . '</style></head><body>'
              . $fragment
              . '</body></html>';

        // Appel à PDFShift via Guzzle
        $client = new Client();
        try {
            $response = $client->post('https://api.pdfshift.io/v3/convert/pdf', [
                'json' => [
                    'source'    => $html,
                    'format'    => 'A4',
                    'landscape' => true,
                    'sandbox'   => false,
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode('api:' . config('services.pdfshift.api_key')),
                    'Content-Type'  => 'application/json',
                ],
                'timeout' => 60,
            ]);

            $pdfContent = $response->getBody()->getContents();
            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="facture_' . ($compteur->numero_facture ?? 'facture') . '.pdf"');

        } catch (RequestException $e) {
            Log::error('Erreur PDFShift : ' . $e->getMessage());
            return response()->json([
                'error' => 'Impossible de générer le PDF. Veuillez réessayer ultérieurement.',
            ], 500);
        }
    }


    public function exportFacturesFiltrees(Request $request)
{
// Récupérer les filtres depuis la requête
$annee = $request->input('annee');
$mois = $request->input('mois');

// Charger les factures filtrées avec leurs relations
$compteurs = Compteur::with('client.tarif')
    ->whereYear('date_releve', $annee)
    ->whereMonth('date_releve', $mois)
    ->get();

    // dd($compteurs);

// Vérifier si des factures existent
if ($compteurs->isEmpty()) {
    return response()->json(['error' => 'Aucune facture trouvée pour les filtres sélectionnés.'], 404);
}

// Calculer le montant en lettres pour chaque facture
$montantEnLettres = [];
$formatter = new \NumberFormatter('fr', \NumberFormatter::SPELLOUT);
foreach ($compteurs as $compteur) {
    $total = $compteur->prix_total ?? 0;
    $montantEnLettres[$compteur->id] = ucfirst($formatter->format($total)) . ' Ariary';
}

// Générer le HTML pour toutes les factures
$fullHtml = View::make('facture.multiple', compact('compteurs', 'montantEnLettres'))->render();

// Extraire les styles CSS du HTML
preg_match_all('/<style[^>]*>([\s\S]*?)<\/style>/', $fullHtml, $styleMatches);
$embeddedCss = !empty($styleMatches[1]) ? implode("\n", $styleMatches[1]) : '';
// Ajouter des styles spécifiques pour PDFShift
$embeddedCss .= "
html, body { background: none !important; margin:0; padding:0;} 
.page { background: white !important; page-break-after: always; }";

// Utiliser le HTML complet comme fragment
$fragment = $fullHtml;

// Construire le HTML final avec CSS embarqué
$html = '<!DOCTYPE html>'
      . '<html><head><meta charset="UTF-8"><style>'
      . $embeddedCss
      . '</style></head><body>'
      . $fragment
      . '</body></html>';

// Appeler PDFShift pour générer le PDF
$client = new Client();
try {
    $response = $client->post('https://api.pdfshift.io/v3/convert/pdf', [
        'json' => [
            'source'    => $html,
            'format'    => 'A4',
            'landscape' => true,
            'sandbox'   => false,
        ],
        'headers' => [
            'Authorization' => 'Basic ' . base64_encode('api:' . config('services.pdfshift.api_key')),
            'Content-Type'  => 'application/json',
        ],
        'timeout' => 60,
    ]);

    $pdfContent = $response->getBody()->getContents();
    return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="factures_' . $annee . '_' . $mois . '.pdf"');

} catch (RequestException $e) {
    Log::error('Erreur PDFShift : ' . $e->getMessage());
    return response()->json([
        'error' => 'Impossible de générer le PDF. Veuillez réessayer ultérieurement.',
    ], 500);
}
}


    
}
