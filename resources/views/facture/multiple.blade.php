<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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

.thead > div {
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
    height: 20px; /* Fixed height for all rows */
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
    @foreach ($compteurs as $compteur)
        <div class="page">
            @include('facture.index', ['compteur' => $compteur, 'montantEnLettres' => $montantEnLettres[$compteur->id]])
        </div>
    @endforeach
</body>
</html>