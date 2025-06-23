<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Compteur;
use Illuminate\Http\Request;
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
            $lastCompteur = $client->compteurs()->latest('date_releve')->first();
            if (!$lastCompteur) {
                return redirect()->back()->withErrors(['error' => 'Aucun compteur trouvé pour ce client.']);
            }
    
            $montantPaye = $request->montant_paye;
            Log::info('Données avant création : ', [
                'client_id' => $request->client_id,
                'montant_paye' => $montantPaye,
                'date_paiement' => $request->date_paiement,
                'compteur_id' => $lastCompteur->id
            ]);
    
            $payment = Payment::create([
                'compteur_id' => $lastCompteur->id,
                'client_id' => $request->client_id,
                'montant_paye' => $montantPaye,
                'date_paiement' => Carbon::parse($request->date_paiement)->toDateString(),
                'reste_a_payer' => 0,
                'statut' => 'en_attente',
            ]);
    
            $payment->updateResteAPayer();
            Log::info('Paiement créé : ', [
                'id' => $payment->id,
                'reste_a_payer' => $payment->reste_a_payer,
                'statut' => $payment->statut
            ]);
    
            return redirect()->route('payments.index', $siteId)
                ->with('success', 'Paiement ajouté avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du paiement : ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()]);
        }
    }
    public function search($siteId, Request $request)
{
    $query = $request->input('query');
    $clients = Client::whereHas('compteurs', function ($q) use ($siteId) {
        $q->where('site_id', $siteId);
    })
    ->where('nom_client', 'like', "%$query%")
    ->with(['compteurs' => function ($q) {
        $q->latest('date_releve');
    }])
    ->get()
    ->map(function ($client) {
        $lastCompteur = $client->compteurs->first();
        return [
            'id' => $client->id,
            'nom_client' => $client->nom_client,
            'compteur_numero' => $lastCompteur ? $lastCompteur->numero_facture : 'N/A',
            'montant_total' => $lastCompteur ? $lastCompteur->prix_total ?? 0 : 0
        ];
    });

    return response()->json($clients);
}
}