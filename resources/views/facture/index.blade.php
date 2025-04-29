<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAKTIORA - Format Paysage</title>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .page,
            .page * {
                visibility: visible;
            }

            .page {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            @page {
                size: A4 landscape;
                margin: 0;
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            font-size: 10px;
            background-color: #f0f0f0;
        }

        /* A4 Landscape Page */
        .page {
            width: 297mm;
            height: 210mm;
            margin: 0 auto;
            background-color: white;
            display: flex;
            box-sizing: border-box;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Invoice Containers */
        .facture-gauche,
        .facture-droite {
            width: 50%;
            padding: 15px;
            padding-top: 45px;
            box-sizing: border-box;
            position: relative;
        }

        .facture-gauche {
            border-right: 1px dashed #000;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: -20px;
            margin-top: -40px;
            padding: 10px;
        }

        .company-info {
            width: 50%;
            display: flex;
            flex-direction: column;
            padding-right: 10px;
        }

        .company-info h1 {
            font-size: 14px;
            margin: 0;
            font-weight: bold;
        }

        .company-info p {
            font-size: 10px;
            margin: 4px 0;
        }

        .faktiora-header {
            width: 45%;
            text-align: right;
            padding-left: 10px;
        }

        .faktiora-header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        /* Client Info Section */
        .client-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin: 10px 0;
            padding: 10px 0;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
        }

        .client-left,
        .client-right {
            display: flex;
            flex-direction: column;
            width: 48%;
        }

        /* Generic Row Styling */
        .row {
            display: flex;
            margin-bottom: 6px;
            justify-content: flex-end;
            align-items: center;
            gap: 30px;
        }

        .row-label {
            width: 40%;
            font-weight: bold;
            text-align: left;
        }

        .row-value {
            width: 60%;
            text-align: right;
        }

        /* Input Box Styling */
        .input-box {
            padding: 5px;
            border: 1px solid #ddd;
            width: 100%;
            font-size: 11px;
            box-sizing: border-box;
            min-height: 14px;
            background-color: white;
        }

        /* Main Table Section */
        .main-table {
            display: flex;
            flex-direction: column;
            font-size: 13px;
            width: 100%;
            border-collapse: separate;
            border-spacing: 4px;
        }

        .thead {
            display: flex;
            font-weight: bold;
            text-align: center;
            margin-bottom: 4px;
        }

        .thead>div {
            flex: 1;
            padding: 4px 6px;
        }

        .label {
            flex: 1;
            font-weight: bold;
            padding: 4px 6px;
            border: none;
            font-size: 10px;
        }

        .cell {
            flex: 1;
            border: 1px solid #ddd;
            padding: 5px;
            text-align: right;
            font-size: 10px;
        }

        /* Faktiora Section (Tables for Sarany and Ketra) */
        .faktiora-section {
            display: flex;
            gap: 40px;
            margin-top: 2px;
        }

        table {
            border-collapse: separate;
            border-spacing: 0 4px;
            font-size: 11px;
            width: 100%;
            max-width: 300px;
        }

        th {
            text-align: left;
            font-weight: bold;
            padding-bottom: 6px;
            background: none;
            border: none;
        }

        td.label {
            font-weight: bold;
            text-align: left;
            padding-right: 10px;
            border: none;
            width: 60%;
        }

        td.value-cell {
            border: 1px solid #ddd;
            padding: 1px 5px;
            width: 40%;
            text-align: right;
        }

        /* Fix Cell Height */
        .table-sarany tr,
        .table-ketra tr {
            height: 20px;
            /* Fixed height for all rows */
            margin-bottom: 5px;

        }

        .table-sarany td,
        .table-ketra td {
            padding: 2px 5px;
            line-height: 16px;
            vertical-align: middle;
            box-sizing: border-box;
        }

        /* Optional: Use Flexbox for Rows */
        .table-sarany tbody tr,
        .table-ketra tbody tr {
            display: flex;
            align-items: center;
        }

        .table-sarany td.label,
        .table-ketra td.label {
            flex: 0 0 60%;
        }

        .table-sarany td.value-cell,
        .table-ketra td.value-cell {
            flex: 0 0 40%;
        }

        /* Footer Section */
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: -10px;
            padding-top: 10px;
        }

        .footer-left {
            width: 40%;
        }

        .footer-right {
            width: 60%
        }

        .footer-left p,
        .footer-right p {
            margin: 0;
            font-size: 11px;
        }

        .footer-right p {
            /* text-align: right; */

            margin-left: 11px;
        }

        .footer-right em {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="page" id="invoice">
        <!-- FACTURE GAUCHE -->
        <div class="facture-gauche">
            <!-- En-tête -->
            <div class="header">
                <div class="company-info">
                    <h1>ENTREPRISE MIHARINDRANO</h1>
                    <p>3001076425</p>
                    <p>Foibe: Lot II F 291 Ambano</p>
                    <p>Famatsian-drano: <strong>{{ $compteur->site->nom_site }}</strong></p>
                </div>
                <div class="faktiora-header">
                    <h1>FAKTIORA</h1>
                    <div class="row">
                        <div class="row-label">Volana</div>
                        <div class="row-value">
                            <div class="input-box">
                                {{ \Carbon\Carbon::parse($compteur->date_releve)->translatedFormat('F/Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Daty</div>
                        <div class="row-value">{{ \Carbon\Carbon::parse($compteur->date_releve)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="row-label">Faktiora n°</div>
                        <div class="row-value">{{ $compteur->numero_facture }}</div>
                    </div>

                </div>
            </div>

            <!-- Informations client -->
            <div class="client-info">
                <div class="client-left">
                    <div class="row">
                        <div class="row-label">Referansa</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->ref }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Mpanjifa</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->nom_client }}</div>
                        </div>
                    </div>
                </div>
                <div class="client-right">
                    <div class="row">
                        <div class="row-label">N° kaontera</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->numero_compteur ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Lazam-bidy</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client?->tarif?->nom_tarif ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="main-table">
                <!-- Thead 1 -->
                <div class="thead">
                    <div></div>
                    <div>Marika teo aloha</div>
                    <div>Marika vaovao</div>
                    <div>Fandaniana (m3)</div>
                </div>

                <!-- Première section -->
                <div class="row">
                    <div class="label">Marika</div>
                    <div class="cell">{{ $compteur->ancien_index }}</div>
                    <div class="cell">{{ $compteur->nouvel_index }}</div>
                    <div class="cell">{{ $compteur->consommation }}</div>
                </div>

                <div class="row">
                    <div class="label">Daty nanamarihana</div>
                    <div class="cell">{{ \Carbon\Carbon::parse($compteur->ancien_date)->format('d/m/Y') }}</div>
                    <div class="cell">{{ \Carbon\Carbon::parse($compteur->date_releve)->format('d/m/Y') }}</div>
                    <div class="cell">0,00</div>
                </div>

                <!-- Thead 2 -->
                <div class="thead">
                    <div></div>
                    <div>Habetsaka m3</div>
                    <div>Vidiny (Ar)</div>
                    <div>Fitambarany (Ar)</div>
                </div>

                <!-- Deuxième section -->
                <div class="row">
                    <div class="label">Ampahany voalohany</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                </div>

                <div class="row">
                    <div class="label">Ampahany faharoa</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                </div>

                <div class="row">
                    <div class="label">Totaly</div>
                    <div class="cell">{{ $compteur->consommation }}</div>
                    <div class="cell">{{ $compteur->client?->tarif?->pu_m3_unique ?? '-' }}</div>
                    <div class="cell">{{ $compteur->prix_par_index }}</div>
                </div>
            </div>




            <!-- Section totaux -->
            <div class="faktiora-section">
                <table class="table-sarany">
                    <thead>
                        <tr>
                            <th colspan="2">Sarany samihafa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="label">Hofan'ny kaontera</td>
                            <td class="value-cell">500,00</td>
                        </tr>
                        <tr>
                            <td class="label">Sarany tsy miova</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Prime fixe</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Sarany hafa</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table-ketra">
                    <thead>
                        <tr>
                            <th colspan="2">Karazan-ketra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="label">Hetra kaominina</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Hetra Hafa</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Hetra FNRE (8Ar/m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">TVA (>10 m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="label">Faktiora <strong>
                                    {{ \Carbon\Carbon::parse($compteur->date_releve)->translatedFormat('F/Y') }}</strong>
                            </td>
                            <td class="value-cell">{{ $compteur->prix_total }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="label">Ambiny tsy voaloa teo aloha</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="label">Vola aloa (Ar)</td>
                            <td class="value-cell">{{ $compteur->prix_total }}</td>
                        </tr>

                </table>
            </div>

            <!-- Pied de page -->
            <div class="footer">
                <div class="footer-left">
                    <p><strong>Daty fetra fandoavana:</strong> 18/10/2024</p>
                </div>
                <div class="footer-right">
                    <p><em>Arrêté la présente facture à la somme de {{ $montantEnLettres }}</em></p>
                </div>
            </div>
        </div>

        <!-- FACTURE DROITE -->
        <div class="facture-droite">
            <!-- En-tête -->
            <div class="header">
                <div class="company-info">
                    <h1>ENTREPRISE MIHARINDRANO</h1>
                    <p>3001076425</p>
                    <p>Foibe: Lot II F 291 Ambano</p>
                    <p>Famatsian-drano: <strong>{{ $compteur->site->nom_site }}</strong></p>
                </div>
                <div class="faktiora-header">
                    <h1>FAKTIORA</h1>
                    <div class="row">
                        <div class="row-label">Volana</div>
                        <div class="row-value">
                            <div class="input-box">
                                {{ \Carbon\Carbon::parse($compteur->date_releve)->translatedFormat('F/Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Daty</div>
                        <div class="row-value">{{ \Carbon\Carbon::parse($compteur->date_releve)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="row-label">Faktiora n°</div>
                        <div class="row-value">{{ $compteur->numero_facture }}</div>
                    </div>

                </div>
            </div>

            <!-- Informations client -->
            <div class="client-info">
                <div class="client-left">
                    <div class="row">
                        <div class="row-label">Referansa</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->ref }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Mpanjifa</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->nom_client }}</div>
                        </div>
                    </div>
                </div>
                <div class="client-right">
                    <div class="row">
                        <div class="row-label">N° kaontera</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client->numero_compteur ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Lazam-bidy</div>
                        <div class="row-value">
                            <div class="input-box">{{ $compteur->client?->tarif?->nom_tarif ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="main-table">
                <!-- Thead 1 -->
                <div class="thead">
                    <div></div>
                    <div>Marika teo aloha</div>
                    <div>Marika vaovao</div>
                    <div>Fandaniana (m3)</div>
                </div>

                <!-- Première section -->
                <div class="row">
                    <div class="label">Marika</div>
                    <div class="cell">{{ $compteur->ancien_index }}</div>
                    <div class="cell">{{ $compteur->nouvel_index }}</div>
                    <div class="cell">{{ $compteur->consommation }}</div>
                </div>

                <div class="row">
                    <div class="label">Daty nanamarihana</div>
                    <div class="cell">{{ \Carbon\Carbon::parse($compteur->ancien_date)->format('d/m/Y') }}</div>
                    <div class="cell">{{ \Carbon\Carbon::parse($compteur->date_releve)->format('d/m/Y') }}</div>
                    <div class="cell">0,00</div>
                </div>

                <!-- Thead 2 -->
                <div class="thead">
                    <div></div>
                    <div>Habetsaka m3</div>
                    <div>Vidiny (Ar)</div>
                    <div>Fitambarany (Ar)</div>
                </div>

                <!-- Deuxième section -->
                <div class="row">
                    <div class="label">Ampahany voalohany</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                </div>

                <div class="row">
                    <div class="label">Ampahany faharoa</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                    <div class="cell">0,00</div>
                </div>

                <div class="row">
                    <div class="label">Totaly</div>
                    <div class="cell">{{ $compteur->consommation }}</div>
                    <div class="cell">{{ $compteur->client?->tarif?->pu_m3_unique ?? '-' }}</div>
                    <div class="cell">{{ $compteur->prix_par_index }}</div>
                </div>
            </div>




            <!-- Section totaux -->
            <div class="faktiora-section">
                <table class="table-sarany">
                    <thead>
                        <tr>
                            <th colspan="2">Sarany samihafa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="label">Hofan'ny kaontera</td>
                            <td class="value-cell">500,00</td>
                        </tr>
                        <tr>
                            <td class="label">Sarany tsy miova</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Prime fixe</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Sarany hafa</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                    </tbody>
                </table>

                <table class="table-ketra">
                    <thead>
                        <tr>
                            <th colspan="2">Karazan-ketra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="label">Hetra kaominina</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Hetra Hafa</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">Hetra FNRE (8Ar/m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">TVA (>10 m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="label">Faktiora <strong>
                                    {{ \Carbon\Carbon::parse($compteur->date_releve)->translatedFormat('F/Y') }}</strong>
                            </td>
                            <td class="value-cell">{{ $compteur->prix_total }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="label">Ambiny tsy voaloa teo aloha</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="label">Vola aloa (Ar)</td>
                            <td class="value-cell">{{ $compteur->prix_total }}</td>
                        </tr>

                </table>
            </div>

            <!-- Pied de page -->
            <div class="footer">
                <div class="footer-left">
                    <p><strong>Daty fetra fandoavana:</strong> 18/10/2024</p>
                </div>
                <div class="footer-right">
                    <p><em>Arrêté la présente facture à la somme de {{ $montantEnLettres }}</em></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
