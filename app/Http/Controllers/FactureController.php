<?php

namespace App\Http\Controllers;

use App\Models\Site;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Models\Compteur;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;

class FactureController extends Controller
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
        return view('facture.index');
    }





    public function generateFacturePDF()
    {
        $html = view('facture.index')->render();

        $client = new Client();

        try {
            $response = $client->post('https://api.pdfshift.io/v3/convert/pdf', [
                'json' => [
                    'source' => $html,
                    'sandbox' => true,
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode('api:' . config('services.pdfshift.api_key')),
                ],
            ]);

            $pdfContent = $response->getBody()->getContents();

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="facture.pdf"');
        } catch (RequestException $e) {
            // \Log::error('Erreur PDFShift : ' . $e->getMessage());
            return response()->json([
                'error' => 'Impossible de générer le PDF. Veuillez réessayer.',
            ], 500);
        }
    }
}