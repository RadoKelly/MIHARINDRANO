<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Site;
use App\Models\Compteur;
use App\Models\Client;
use Illuminate\Http\Request;

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
        $request->validate([
            'compteur_id' => 'required|exists:compteurs,id',
            'client_id' => 'required|exists:clients,id',
            'montant_paye' => 'required|numeric|min:0',
            'date_paiement' => 'nullable|date',
        ]);

        $payment = Payment::create([
            'compteur_id' => $request->compteur_id,
            'client_id' => $request->client_id,
            'montant_paye' => $request->montant_paye,
            'date_paiement' => $request->date_paiement ?: now(),
            'statut' => 'en_attente',
        ]);

        $payment->updateResteAPayer();

        return redirect()->route('payments.index', $siteId)->with('success', 'Paiement ajouté avec succès.');
    }
}