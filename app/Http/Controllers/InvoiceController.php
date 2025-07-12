<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Compteur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function generatePDF($siteId, $compteurId)
    {
        $site = Site::findOrFail($siteId);
        $compteur = Compteur::where('site_id', $siteId)->with(['paiements' => function ($query) {
            $query->latest()->first(); // Récupère le dernier paiement
        }])->findOrFail($compteurId);
        $pdf = Pdf::loadView('facture.twofacture', compact('site', 'compteur'));

        // Configuration papier A4 paysage
        $pdf->setPaper('A4', 'landscape');
            
        // Options Dompdf pour un rendu optimal
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

        // Générer le nom du fichier avec le nom du client et le numéro de facture
        $clientName = Str::slug($compteur->client->nom_client ?? 'client-inconnu');
        $numeroFacture = $compteur->getInvoiceData()['numero_facture'] ?? 'FACT-UNKNOWN';
        $fileName = "facture_{$clientName}_{$numeroFacture}.pdf";

        return $pdf->download($fileName);
    }

    public function batchExport(Request $request)
    {
        Log::info('Données reçues dans batchExport :', $request->all());

        $request->validate([
            'compteurs' => 'required|array',
            'compteurs.*.site_id' => 'required|exists:sites,id',
            'compteurs.*.compteur_id' => 'required|exists:compteurs,id',
        ]);

        $compteursData = $request->input('compteurs');
        $compteurs = [];

        foreach ($compteursData as $data) {
            $compteur = Compteur::with(['client.tarif', 'site'])
                ->where('site_id', $data['site_id'])
                ->find($data['compteur_id']);
                
            if (!$compteur) {
                Log::error('Compteur non trouvé :', $data);
                continue;
            }

            if (!$compteur->site) {
                Log::error('Site non trouvé pour compteur ID : ' . $data['compteur_id']);
                continue;
            }
            if (!$compteur->client) {
                Log::error('Client non trouvé pour compteur ID : ' . $data['compteur_id']);
                continue;
            }

            $compteurs[] = [
                'compteur' => $compteur,
                'site' => $compteur->site,
            ];
        }

        Log::info('Compteurs chargés :', $compteurs);

        if (empty($compteurs)) {
            return response()->json(['error' => 'Aucun compteur valide trouvé'], 422);
        }

        $pdf = Pdf::loadView('facture.batch', compact('compteurs'));

        $pdf->setPaper('A4', 'landscape');
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

        $fileName = 'factures_filtrees_' . now()->format('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }
    
}
