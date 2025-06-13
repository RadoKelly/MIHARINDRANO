<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Factures Filtrées - A4 Paysage (Dompdf)</title>
    <style>
        /* Page definition pour Dompdf */
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        /* Utiliser display: table pour aligner deux factures */
        .invoice-wrapper {
            width: 100%;
            display: table;
            table-layout: fixed;
            page-break-after: always;
            margin-bottom: 0;
        }

        .invoice-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            box-sizing: border-box;
            padding: 5mm;
        }

        /* Séparateur au milieu */
        .invoice-block.left {
            border-right: 1px dashed #000;
            padding-right: 5mm;
        }

        .invoice-block.right {
            padding-left: 5mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
            table-layout: fixed;
        }

        th, td {
            padding: 2mm;
            border: 1px solid #333;
            vertical-align: top;
            font-size: 9pt;
        }

        th {
            font-weight: bold;
            text-align: left;
        }

        .header-table td {
            border: none;
            padding: 0;
            padding-bottom: 3mm;
        }

        .header-title {
            font-size: 12pt;
            font-weight: bold;
        }

        .client-table td {
            border: none;
            padding: 1mm 2mm;
        }

        .main-table .label {
            text-align: left;
        }

        .main-table td, .main-table th {
            text-align: center;
        }

        /* Totaux section */
        .totals-container {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        .totals-cell {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            box-sizing: border-box;
            padding-right: 2mm;
        }

        .totals-cell:last-child {
            padding-right: 0;
            padding-left: 2mm;
        }

        .inner-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .inner-table th, .inner-table td {
            border: 1px solid #333;
            padding: 1.5mm;
            font-size: 8pt;
        }

        .inner-table th {
            font-weight: bold;
            text-align: left;
        }

        .footer-text {
            font-size: 8pt;
            margin-top: 3mm;
        }

        /* Éviter les coupures de page */
        .invoice-block {
            page-break-inside: avoid;
        }

        /* Réduire les marges */
        .main-table th, .main-table td {
            padding: 1.5mm;
        }
    </style>
</head>
<body>
    @php
        $compteurs = array_chunk($compteurs, 2); // Diviser les compteurs en paires
    @endphp

    @foreach ($compteurs as $pair)
        <div class="invoice-wrapper">
            <!-- Facture Gauche -->
            <div class="invoice-block left">
                @if (isset($pair[0]))
                    @php $compteur = $pair[0]['compteur']; @endphp
                    <table class="header-table">
                        <tr>
                            <td style="width: 60%;">
                                <strong>ENTREPRISE MIHARINDRANO</strong><br>
                                3001076425<br>
                                Lot II F 291 Ambano<br>
                                Famatsian-drano: <strong>{{ $compteur->getInvoiceData()['site_nom'] }}</strong>
                            </td>
                            <td style="text-align: right; width: 40%;">
                                <div class="header-title">FAKTIORA</div>
                                Volana: {{ $compteur->getInvoiceData()['date_releve_formatted'] }}<br>
                                Daty: {{ $compteur->getInvoiceData()['date_releve'] }}<br>
                                Faktiora n°: {{ $compteur->getInvoiceData()['numero_facture'] }}
                            </td>
                        </tr>
                    </table>

                    <table class="client-table">
                        <tr>
                            <td style="width: 30%;">Réf:</td>
                            <td>{{ $compteur->getInvoiceData()['client_ref'] }}</td>
                        </tr>
                        <tr>
                            <td>Mpanjifa:</td>
                            <td>{{ $compteur->getInvoiceData()['client_nom'] }}</td>
                        </tr>
                        <tr>
                            <td>Kaontera:</td>
                            <td>{{ $compteur->getInvoiceData()['client_numero_compteur'] }}</td>
                        </tr>
                        <tr>
                            <td>Lazam-bidy:</td>
                            <td>{{ $compteur->getInvoiceData()['tarif_nom'] }}</td>
                        </tr>
                    </table>

                    <table class="main-table">
                        <colgroup>
                            <col style="width: 30%;">
                            <col style="width: 23.33%;">
                            <col style="width: 23.33%;">
                            <col style="width: 23.33%;">
                        </colgroup>
                        <tr>
                            <th></th>
                            <th>Marika ancien</th>
                            <th>Marika nouveau</th>
                            <th>Consommation (m³)</th>
                        </tr>
                        <tr>
                            <td class="label">Marika</td>
                            <td>{{ $compteur->getInvoiceData()['ancien_index'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['nouvel_index'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['consommation'] }}</td>
                        </tr>
                        <tr>
                            <td class="label">Dates</td>
                            <td>{{ $compteur->getInvoiceData()['ancien_date'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['date_releve'] }}</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Volume (m³)</th>
                            <th>Prix (Ar)</th>
                            <th>Total (Ar)</th>
                        </tr>
                        <tr>
                            <td class="label">Part 1</td>
                            <td>0,00</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Part 2</td>
                            <td>0,00</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Total</td>
                            <td>{{ $compteur->getInvoiceData()['consommation'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['tarif_pu_m3_unique'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['prix_par_index'] }}</td>
                        </tr>
                    </table>

                    <div class="totals-container">
                        <div class="totals-cell">
                            <table class="inner-table">
                                <tr>
                                    <th colspan="2">Sarany samihafa</th>
                                </tr>
                                <tr>
                                    <td>Hofan'ny kaontera</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['frais_compteur'] }}</td>
                                </tr>
                                <tr>
                                    <td>Sarany tsy miova</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['sarany_tsy_miova'] }}</td>
                                </tr>
                                <tr>
                                    <td>Prime fixe</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['prime_fixe'] }}</td>
                                </tr>
                                <tr>
                                    <td>Sarany haya</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['sarany_hafa'] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="totals-cell">
                            <table class="inner-table">
                                <tr>
                                    <th colspan="2">Karazan-ketra</th>
                                </tr>
                                <tr>
                                    <td>Hetra kaominina</td>
                                    <td style="text-align: right;">0,00</td>
                                </tr>
                                <tr>
                                    <td>Hetra Hafa</td>
                                    <td style="text-align: right;">0,00</td>
                                </tr>
                                <tr>
                                    <td>Hetra FNRE (8Ar/m³)</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['hetra_fnre'] }}</td>
                                </tr>
                                <tr>
                                    <td>TVA (>10 m³)</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['tva'] }}</td>
                                </tr>
                                <tr>
                                    <td>Faktiora {{ $compteur->getInvoiceData()['date_releve_formatted'] }}</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['prix_total'] }}</td>
                                </tr>
                                <tr>
                                    <td>Ambiny tsy voaloa teo aloha</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['ambiny_tsy_voaloa'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vola aloa (Ar)</strong></td>
                                    <td style="text-align: right;"><strong>{{ $compteur->getInvoiceData()['prix_total'] }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="footer-text">
                        <strong>Date limite:</strong> {{ $compteur->getInvoiceData()['date_fetra_fandoavana'] }}<br>
                        <em>Arrêté la présente facture à la somme de {{ $compteur->getInvoiceData()['montant_en_lettres'] }}</em>
                    </div>
                @endif
            </div>

            <!-- Facture Droite -->
            <div class="invoice-block right">
                @if (isset($pair[1]))
                    @php $compteur = $pair[1]['compteur']; @endphp
                    <table class="header-table">
                        <tr>
                            <td style="width: 60%;">
                                <strong>ENTREPRISE MIHARINDRANO</strong><br>
                                3001076425<br>
                                Lot II F 291 Ambano<br>
                                Famatsian-drano: <strong>{{ $compteur->getInvoiceData()['site_nom'] }}</strong>
                            </td>
                            <td style="text-align: right; width: 40%;">
                                <div class="header-title">FAKTIORA</div>
                                Volana: {{ $compteur->getInvoiceData()['date_releve_formatted'] }}<br>
                                Daty: {{ $compteur->getInvoiceData()['date_releve'] }}<br>
                                Faktiora n°: {{ $compteur->getInvoiceData()['numero_facture'] }}
                            </td>
                        </tr>
                    </table>

                    <table class="client-table">
                        <tr>
                            <td style="width: 30%;">Réf:</td>
                            <td>{{ $compteur->getInvoiceData()['client_ref'] }}</td>
                        </tr>
                        <tr>
                            <td>Mpanjifa:</td>
                            <td>{{ $compteur->getInvoiceData()['client_nom'] }}</td>
                        </tr>
                        <tr>
                            <td>Kaontera:</td>
                            <td>{{ $compteur->getInvoiceData()['client_numero_compteur'] }}</td>
                        </tr>
                        <tr>
                            <td>Lazam-bidy:</td>
                            <td>{{ $compteur->getInvoiceData()['tarif_nom'] }}</td>
                        </tr>
                    </table>

                    <table class="main-table">
                        <colgroup>
                            <col style="width: 30%;">
                            <col style="width: 23.33%;">
                            <col style="width: 23.33%;">
                            <col style="width: 23.33%;">
                        </colgroup>
                        <tr>
                            <th></th>
                            <th>Marika ancien</th>
                            <th>Marika nouveau</th>
                            <th>Consommation (m³)</th>
                        </tr>
                        <tr>
                            <td class="label">Marika</td>
                            <td>{{ $compteur->getInvoiceData()['ancien_index'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['nouvel_index'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['consommation'] }}</td>
                        </tr>
                        <tr>
                            <td class="label">Dates</td>
                            <td>{{ $compteur->getInvoiceData()['ancien_date'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['date_releve'] }}</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Volume (m³)</th>
                            <th>Prix (Ar)</th>
                            <th>Total (Ar)</th>
                        </tr>
                        <tr>
                            <td class="label">Part 1</td>
                            <td>0,00</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Part 2</td>
                            <td>0,00</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Total</td>
                            <td>{{ $compteur->getInvoiceData()['consommation'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['tarif_pu_m3_unique'] }}</td>
                            <td>{{ $compteur->getInvoiceData()['prix_par_index'] }}</td>
                        </tr>
                    </table>

                    <div class="totals-container">
                        <div class="totals-cell">
                            <table class="inner-table">
                                <tr>
                                    <th colspan="2">Sarany samihafa</th>
                                </tr>
                                <tr>
                                    <td>Hofan'ny kaontera</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['frais_compteur'] }}</td>
                                </tr>
                                <tr>
                                    <td>Sarany tsy miova</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['sarany_tsy_miova'] }}</td>
                                </tr>
                                <tr>
                                    <td>Prime fixe</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['prime_fixe'] }}</td>
                                </tr>
                                <tr>
                                    <td>Sarany haya</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['sarany_hafa'] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="totals-cell">
                            <table class="inner-table">
                                <tr>
                                    <th colspan="2">Karazan-ketra</th>
                                </tr>
                                <tr>
                                    <td>Hetra kaominina</td>
                                    <td style="text-align: right;">0,00</td>
                                </tr>
                                <tr>
                                    <td>Hetra Hafa</td>
                                    <td style="text-align: right;">0,00</td>
                                </tr>
                                <tr>
                                    <td>Hetra FNRE (8Ar/m³)</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['hetra_fnre'] }}</td>
                                </tr>
                                <tr>
                                    <td>TVA (>10 m³)</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['tva'] }}</td>
                                </tr>
                                <tr>
                                    <td>Faktiora {{ $compteur->getInvoiceData()['date_releve_formatted'] }}</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['prix_total'] }}</td>
                                </tr>
                                <tr>
                                    <td>Ambiny tsy voaloa teo aloha</td>
                                    <td style="text-align: right;">{{ $compteur->getInvoiceData()['ambiny_tsy_voaloa'] }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Vola aloa (Ar)</strong></td>
                                    <td style="text-align: right;"><strong>{{ $compteur->getInvoiceData()['prix_total'] }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="footer-text">
                        <strong>Date limite:</strong> {{ $compteur->getInvoiceData()['date_fetra_fandoavana'] }}<br>
                        <em>Arrêté la présente facture à la somme de {{ $compteur->getInvoiceData()['montant_en_lettres'] }}</em>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</body>
</html>