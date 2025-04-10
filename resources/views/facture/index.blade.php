<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAKTIORA - Format Paysage</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
            font-size: 10px;
            background-color: #f0f0f0;
        }

        /* Page au format paysage A4 */
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

        /* Conteneurs pour les deux factures */
        .facture-gauche,
        .facture-droite {
            width: 50%;
            padding: 15px;
            padding-top: 45px;
            box-sizing: border-box;
            position: relative;
        }

        /* Ligne de séparation verticale */
        .facture-gauche {
            border-right: 1px dashed #000;
        }

        /* Style d'en-tête */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .company-info {
            width: 50%;

        }

        .company-info h1 {
            font-size: 12px;
            margin: 0;
            font-weight: bold;
        }

        .faktiora-header {
            text-align: right;
            width: 50%;
        }

        .faktiora-header h1 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        /* Section client */
        .client-info {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin: 20px 0;
    padding: 10px 0;
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
}

.client-left, .client-right {
    display: flex;
    flex-direction: column;
    width: 48%; /* Prendre environ la moitié de la largeur */
}

.row {
    display: flex;
    margin-bottom: 10px;/* Alignement vertical centré */
}

.row-label {
    width: 30%; /* Largeur du label */
    font-weight: bold;
    text-align: left;
}

.row-value {
    width: 70%; /* Largeur de la valeur */
}

.input-box {
    display: inline-block;
    padding: 5px;
    border: 1px solid #ddd;
    width: 100%;
}


        .client-left {
            width: 50%;
        }

        .client-right {
            width: 40%;
        }

        /* Zone principale */
        .main-content {
            display: flex;
            margin-bottom: 10px;
        }

        .left-column,
        .middle-column,
        .right-column,
        .first-column {
            flex: 1;
            padding: 0 2px;
        }

        /* Cases de saisie */
        .input-box {
            border: 1px solid #999;
            padding: 2px 4px;
            margin: 2px 0;
            min-height: 14px;
            background-color: white;
        }

        /* Étiquettes */
        .label {
            font-size: 10px;
            color: #000;
            margin: 2px 0;
        }

        .bold-label {
            font-weight: bold;
        }

        /* Totaux */
        .totals {
            display: flex;
            margin-top: 5px;
        }

        .left-totals {
            width: 40%;
        }

        .right-totals {
            width: 60%;
        }

        /* Tampon */
        .stamp {
            position: relative;
            width: 60px;
            height: 60px;
            margin-top: 15px;
            margin-left: 10px;
        }





        /* Alignement des nombres */
        .number-right {
            text-align: right;
        }

        /* Rangées avec disposition flex */
        .row {
            display: flex;
            margin-bottom: 2px;
        }

        .row-label {
            width: 50%;
        }

        .row-value {
            width: 50%;
            text-align: right;
        }

        /* Bordures pointillées droite */
        .right-border {
            height: 100%;
            border-right: 1px dashed #000;
            position: absolute;
            right: 15px;
            top: 0;
        }


        /* Header */
.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px; /* Ajouter un peu plus d'espace sous l'en-tête */
    padding: 10px;
}

.company-info {
    width: 50%;
    display: flex;
    flex-direction: column;
    padding-right: 10px; /* Espacement à droite */
}

.company-info h1 {
    font-size: 14px;
    margin: 0;
    font-weight: bold;
}

.company-info p {
    font-size: 10px; /* Plus petit pour les informations supplémentaires */
    margin: 4px 0;
}

.faktiora-header {
    width: 45%; /* Ajuster la largeur pour une meilleure proportion */
    text-align: right;
    padding-left: 10px; /* Espacement à gauche */
}

.faktiora-header h1 {
    font-size: 16px;
    font-weight: bold;
    margin: 0;
}

.row {
    display: flex;
    margin-bottom: 6px; /* Espacement un peu plus grand entre les lignes */
    justify-content: flex-end; /* Aligner les champs à droite */
}

.row-label {
    width: 40%; /* Ajuster la largeur pour les labels */
    font-weight: bold;
}

.row-value {
    width: 60%; /* Ajuster la largeur pour les valeurs */
    text-align: right;
}

.input-box {
    padding: 5px;
    border: 1px solid #ddd;
    width: 100%;
    font-size: 11px;
}

.main-table {
    display: flex;
    flex-direction: column;
    font-size: 13px;
    width: 100%;
    border-collapse: separate;
    border-spacing: 4px; /* Espace entre cellules */
}

/* En-têtes (thead) */
.thead {
    display: flex;
    font-weight: bold;
    text-align: center;
    margin-bottom: 4px;
}

.thead > div {
    flex: 1;
    padding: 4px 6px;
}

/* Ligne de données */
.row {
    display: flex;
    gap: 5px;
}

/* Première colonne (libellés) */
.label {
    flex: 1;
    font-weight: bold;
    padding: 4px 6px;
    border: none;
}

/* Cellules de valeur */
.cell {
    flex: 1;
    border: 1px solid #ddd;
    padding: 1px 5px;
    text-align: right;
    font-size: 10px; 
}

.faktiora-section {
    display: flex;
    gap: 40px;
    margin-top: 20px;
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

.footer {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding-top: 10px;
}

.footer-left,
.footer-right {
    width: 48%;
}

.footer-left p,
.footer-right p {
    margin: 0;
    font-size: 11px;
}

.footer-right p {
    text-align: right;
}

.footer-right em {
    font-style: italic;
}




    </style>
</head>

<body>
    <div class="page">
        <!-- FACTURE GAUCHE -->
        <div class="facture-gauche">
            <!-- En-tête -->
            <div class="header">
                <div class="company-info">
                    <h1>ENTREPRISE MIHARINDRANO</h1>
                    <p>3001076425</p>
                    <p>Foibe: Lot II F 291 Ambano</p>
                    <p>Famatsian-drano: <strong>VINANINKARENA</strong></p>
                </div>
                <div class="faktiora-header">
                    <h1>FAKTIORA</h1>
                    <div class="row">
                        <div class="row-label">Volana</div>
                        <div class="row-value">
                            <div class="input-box">Septembre/2024</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Daty</div>
                        <div class="row-value">03/10/2024</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Faktiora n°</div>
                        <div class="row-value">3 054 202409</div>
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            <div class="client-info">
                <div class="client-left">
                    <div class="row">
                        <div class="row-label">Referansa</div>
                        <div class="row-value">
                            <div class="input-box">479 ABT 054</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Mpanjifa</div>
                        <div class="row-value">
                            <div class="input-box">Randriatsizafy Tiana Hasivololo</div>
                        </div>
                    </div>
                </div>
                <div class="client-right">
                    <div class="row">
                        <div class="row-label">N° kaontera</div>
                        <div class="row-value">
                            <div class="input-box">70462829</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Lazam-bidy</div>
                        <div class="row-value">
                            <div class="input-box">COMPTEUR 1</div>
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
                    <div class="cell">1,000</div>
                    <div class="cell">1,000</div>
                    <div class="cell">0,000</div>
                </div>
            
                <div class="row">
                    <div class="label">Daty nanamarihana</div>
                    <div class="cell">09/08/2024</div>
                    <div class="cell">06/09/2024</div>
                    <div class="cell"></div>
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
                    <div class="label">Ampahany voalohan</div>
                    <div class="cell">0,000</div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>
            
                <div class="row">
                    <div class="label">Ampahany faharoa</div>
                    <div class="cell">0,000</div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>
            
                <div class="row">
                    <div class="label">Totaly</div>
                    <div class="cell">0,000</div>
                    <div class="cell">1 800,00</div>
                    <div class="cell">0,00</div>
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
                            <td class="value-cell"></td>
                        </tr>
                        <tr>
                            <td class="label">Prime fixe</td>
                            <td class="value-cell"></td>
                        </tr>
                        <tr>
                            <td class="label">Sarany hafa</td>
                            <td class="value-cell"></td>
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
                            <td class="value-cell"></td>
                        </tr>
                        <tr>
                            <td class="label">Hetra FNRE (8Ar/m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                        <tr>
                            <td class="label">TVA (>10 m3)</td>
                            <td class="value-cell">0,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
             <!-- Pied de page -->
            <div class="footer">
                <div class="footer-left">
                    <p><strong>Daty fetra fandoavana:</strong> 18/10/2024</p>
                </div>
                <div class="footer-right">
                    <p><em>Arrêté la présente facture à la somme de deux mille trois cents Ariary</em></p>
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
                    <p>Famatsian-drano: <strong>VINANINKARENA</strong></p>
                </div>
                <div class="faktiora-header">
                    <h1>FAKTIORA</h1>
                    <div class="row">
                        <div class="row-label">Volana</div>
                        <div class="row-value">
                            <div class="input-box">Septembre/2024</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Daty</div>
                        <div class="row-value">03/10/2024</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Faktiora n°</div>
                        <div class="row-value">3 056 202409</div>
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            <div class="client-info">
                <div class="client-left">
                    <div class="row">
                        <div class="row-label">Referansa</div>
                        <div class="row-value">
                            <div class="input-box">479 ABT 056</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Mpanjifa</div>
                        <div class="row-value">
                            <div class="input-box">Rasoaniandrina Lys Adèle</div>
                        </div>
                    </div>
                </div>
                <div class="client-right">
                    <div class="row">
                        <div class="row-label">N° kaontera</div>
                        <div class="row-value">
                            <div class="input-box">70462827</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row-label">Lazam-bidy</div>
                        <div class="row-value">
                            <div class="input-box">COMPTEUR 1</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="main-content">
                <div class="left-column">
                    <div class="label bold-label">Marika teo aloha</div>
                    <div class="input-box">3,000</div>
                    <div class="label">Daty nanamarihana</div>
                    <div class="input-box">09/08/2024</div>
                    <div class="label bold-label">Habetsaka m3</div>
                    <div class="label">Ampahany voalohan</div>
                    <div class="input-box"></div>
                    <div class="label">Ampahany faharoa</div>
                    <div class="input-box">0,000</div>
                    <div class="label">Totaly</div>
                    <div class="input-box">1,000</div>
                </div>
                <div class="middle-column">
                    <div class="label bold-label">Marika vaovao</div>
                    <div class="input-box">4,000</div>
                    <div class="label">Daty nanamarihana</div>
                    <div class="input-box">06/09/2024</div>
                    <div class="label bold-label">Vidiny (Ar)</div>
                    <div class="input-box"></div>
                    <div class="input-box"></div>
                    <div class="input-box"></div>
                    <div class="input-box">1 800,00</div>
                </div>
                <div class="right-column">
                    <div class="label bold-label">Fandaniana (m3)</div>
                    <div class="input-box">1,000</div>
                    <div class="label"></div>
                    <div class="input-box"></div>
                    <div class="label bold-label">Fitambarany (Ar)</div>
                    <div class="input-box">0,00</div>
                    <div class="input-box">0,00</div>
                    <div class="input-box"></div>
                    <div class="input-box">1 800,00</div>
                </div>
            </div>

            <!-- Section totaux -->
            <div class="totals">
                <div class="left-totals">
                    <div class="label bold-label">Sarany samihafa</div>
                    <div class="row">
                        <div class="row-label">Hofan'ny kaontera</div>
                        <div class="row-value">500,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Sarany tsy miova</div>
                        <div class="row-value"></div>
                    </div>
                    <div class="row">
                        <div class="row-label">Prime fixe</div>
                        <div class="row-value"></div>
                    </div>
                    <div class="row">
                        <div class="row-label">Sarany hafa</div>
                        <div class="row-value"></div>
                    </div>
                    <div class="row">
                        <div class="row-label">Ny Tompon'andraikitra</div>
                        <div class="row-value"></div>
                    </div>

                </div>
                <div class="right-totals">
                    <div class="label bold-label">Karazan-ketra</div>
                    <div class="row">
                        <div class="row-label">Hetra kaominaly</div>
                        <div class="row-value">0,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Hetra Hafa</div>
                        <div class="row-value">0,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Hetra FNRE (8Ar/m3)</div>
                        <div class="row-value">0,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">TVA (>10 m3)</div>
                        <div class="row-value">0,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Faktiora Septembre/2024</div>
                        <div class="row-value">2 300,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label">Ambiny tsy voaloa teo aloha</div>
                        <div class="row-value">0,00</div>
                    </div>
                    <div class="row">
                        <div class="row-label"><strong>Vola aloa (Ar)</strong></div>
                        <div class="row-value"><strong>2 300,00</strong></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="row-label">Daty fefra fandoavana</div>
                <div class="row-value">18/10/2024</div>
            </div>
            <div class="row">
                <div class="row-label">Arrêté la présente facture à la somme de</div>
                <div class="row-value">deux mille trois cents Ariary</div>
            </div>

        </div>
    </div>
</body>

</html>
