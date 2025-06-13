<div class="invoice-block right">
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
                            <td style="text-align: right;">0,00</td>
                        </tr>
                        <tr>
                            <td>TVA (>10 m³)</td>
                            <td style="text-align: right;">0,00</td>
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
        </div>