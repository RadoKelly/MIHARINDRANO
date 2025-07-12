<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Compteur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index($siteId)
    {
        $site = Site::findOrFail($siteId); // Récupère l'objet Site
        $payments = Payment::whereHas('compteur', function ($query) use ($siteId) {
            $query->where('site_id', $siteId);
        })->with(['compteur', 'client'])->get();

        return view('payment.index', compact('payments', 'siteId', 'site'));
    }

    public function create($siteId)
    {
        $site = Site::findOrFail($siteId); // Récupère l'objet Site pour la vue create
        $compteurs = Compteur::where('site_id', $siteId)->get();
        $clients = Client::all(); // Ajuste selon ta logique si les clients sont liés au site
        return view('payments.create', compact('compteurs', 'clients', 'siteId', 'site'));
    }

    public function store(Request $request, $siteId)
    {
        try {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'montant_paye' => 'required|numeric|min:0',
                'date_paiement' => 'required|date',
            ]);
    
            $client = Client::findOrFail($request->client_id);
            // Vérifier que le client appartient exclusivement au site actuel
            $clientCompteurs = $client->compteurs()->get();
            if ($clientCompteurs->isEmpty() || !$clientCompteurs->every(function ($compteur) use ($siteId) {
                return $compteur->site_id == $siteId;
            })) {
                return redirect()->back()->withErrors(['error' => 'Ce client n\'appartient pas au site actuel.']);
            }
    
            $lastCompteur = $client->compteurs()->where('site_id', $siteId)->latest('date_releve')->first();
            if (!$lastCompteur) {
                return redirect()->back()->withErrors(['error' => 'Aucun compteur trouvé pour ce client dans ce site.']);
            }
    
            $montantPaye = $request->montant_paye;
            $payment = Payment::create([
                'compteur_id' => $lastCompteur->id,
                'client_id' => $request->client_id,
                'montant_paye' => $montantPaye,
                'date_paiement' => Carbon::parse($request->date_paiement)->toDateString(),
                'reste_a_payer' => 0,
                'statut' => 'en_attente',
            ]);
    
            $payment->updateResteAPayer();
    
            return redirect()->route('payments.index', $siteId)
                ->with('success', 'Paiement ajouté avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du paiement : ', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }
    public function search($siteId, Request $request)
    {
        $query = $request->input('query');
        Log::info('Search query: ' . $query . ', Site ID: ' . $siteId); // Débogage
        
        $clients = Client::whereHas('compteurs', function ($q) use ($siteId) {
            $q->where('site_id', $siteId);
        })
        ->where('nom_client', 'like', "%$query%")
        ->with(['compteurs' => function ($q) use ($siteId) {
            $q->where('site_id', $siteId)->latest('date_releve');
        }])
        ->get()
        ->filter(function ($client) use ($siteId) {
            $allCompteurs = $client->compteurs()->withoutGlobalScopes()->get();
            if ($allCompteurs->isEmpty()) {
                Log::info('Client ' . $client->id . ' has no compteurs');
                return false;
            }
            $isValid = $allCompteurs->every(function ($compteur) use ($siteId) {
                return $compteur->site_id == $siteId;
            });
            if (!$isValid) {
                Log::info('Client ' . $client->id . ' has compteurs from other sites');
            }
            return $isValid;
        })
        ->map(function ($client) {
            $lastCompteur = $client->compteurs->first();
            return [
                'id' => $client->id,
                'nom_client' => $client->nom_client,
                'compteur_numero' => $lastCompteur ? $lastCompteur->numero_facture : 'N/A',
                'montant_total' => $lastCompteur ? $lastCompteur->prix_total ?? 0 : 0
            ];
        });
    
        Log::info('Found clients: ' . $clients->count()); // Débogage
        return response()->json($clients->values());
    }
    
    public function exportFiche(Request $request)
    {
        $annee = $request->input('annee');
        $mois = $request->input('mois');
    
        $payments = Payment::with(['client.tarif', 'compteur'])
            ->whereYear('date_paiement', $annee)
            ->whereMonth('date_paiement', $mois)
            ->get();
    
        $pdf = Pdf::loadView('payment.fiche_pdf', [
            'payments' => $payments,
            'annee' => $annee,
            'mois' => $mois,
        ]);
    
        // Application des options personnalisées
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'Arial',
            'dpi' => 150,
            'fontSubsetting' => true,
            'isRemoteEnabled' => false,
            'debugPng' => false,
            'debugKeepTemp' => false,
            'debugCss' => false,
            'enable_font_subsetting' => true,
            'pdf_backend' => 'CPDF',
            'defaultPaperSize' => 'A4',
            'chroot' => public_path(),
        ]);
    
        return $pdf->download("fiche_paiement_{$annee}_{$mois}.pdf");
    }
    
    
}