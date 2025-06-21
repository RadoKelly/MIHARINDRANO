<?php

namespace App\Http\Controllers;

use App\Models\Compteur;
use App\Models\Site;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureController extends Controller
{
    public function index(Site $site)
    {
        $compteurs = Compteur::where('site_id', $site->id)
            ->with(['client', 'site'])
            ->orderBy('date_releve', 'desc')
            ->get();
        return view('facture.index', compact('compteurs', 'site'));
    }

    public function export(Request $request, Site $site)
    {
        $compteurIds = $request->input('compteur_ids', []);
        if (empty($compteurIds)) {
            return redirect()->route('listeFacture', ['site' => $site->id])->with('error', 'Aucune facture sélectionnée.');
        }

        $compteurs = Compteur::where('site_id', $site->id)
            ->whereIn('id', $compteurIds)
            ->with(['client', 'site'])
            ->orderBy('date_releve', 'desc')
            ->get();

        $pdf = Pdf::loadView('facture.batch', ['compteurs' => $compteurs->map(fn($c) => ['compteur' => $c])]);
        $filename = 'factures_' . $site->nom_site . '_' . now()->format('Y-m-d_His') . '.pdf';
        return $pdf->download($filename);
    }
}