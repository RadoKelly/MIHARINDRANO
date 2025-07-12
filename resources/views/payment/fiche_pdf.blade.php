<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Paiement - {{ $annee }}/{{ $mois }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>FICHE DE PAIEMENT - {{ \Carbon\Carbon::createFromDate($annee, $mois, 1)->translatedFormat('F Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th>Ref</th>
                <th>Anaran'ny mpanjifa</th>
                <th>N° Facture</th>
                <th>Tarif</th>
                <th>m³</th>
                <th>Vidy TTC (Ar)</th>
                <th>Daty nandohavana</th>
                <th>Vola naloha (Ar)</th>
                <th>Sonia sy Fanamarihana</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                @php
                    $compteur = $payment->compteur;
                    $client = $payment->client;
                    $tarif = $client->tarif ?? null;
                    $invoice = $compteur ? $compteur->getInvoiceData() : null;
                @endphp
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $client->nom_client ?? 'N/A' }}</td>
                    <td>{{ $compteur->numero_facture ?? 'N/A' }}</td>
                    <td>{{ $tarif->nom_tarif ?? 'N/A' }}</td>
                    <td>{{ $invoice['consommation'] ?? '0.00' }}</td>
                    <td>{{ $invoice['prix_total'] ?? '0.00' }}</td>
                    <td></td> <!-- Champ vide : Daty nandohavana -->
                    <td></td> <!-- Champ vide : Vola naloha -->
                    <td></td> <!-- Champ vide : Sonia sy Fanamarihana -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
