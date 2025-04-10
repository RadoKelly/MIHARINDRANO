<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Site;
use App\Models\Compteur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


    public function testPDF()
    {
        // Créer une instance de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Contenu HTML simple pour le PDF
        $html = '
            <html>
                <head>
                    <title>Test PDF</title>
                </head>
                <body>
                    <h1 style="text-align:center;">Ceci est un test de Dompdf</h1>
                    <p style="text-align:center;">Si vous voyez ce texte dans un PDF, alors Dompdf fonctionne !</p>
                </body>
            </html>
        ';

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Définir la taille du papier A4
        $dompdf->setPaper('A4', 'portrait'); // Orientation portrait

        // Rendre le PDF
        $dompdf->render();

        // Afficher le PDF dans le navigateur
        return $dompdf->stream('test-pdf.pdf', [
            'Attachment' => 0 // 0 pour afficher dans le navigateur, 1 pour forcer le téléchargement
        ]);
    }
}
