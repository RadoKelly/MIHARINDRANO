@extends('layouts.app')

@section('navbar')
    @include('navbar', ['site' => $site])
@endsection

@section('content')
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-700 text-center w-full">Relevé Consommations Clients - {{ $site->nom_site }}</h1>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
            <!-- Filtres à gauche -->
            <div class="flex items-center gap-4">
                <!-- Filtre Année -->
                <div class="relative">
                    <label for="filterYear" class="block text-sm font-medium text-gray-600">Année</label>
                    <select id="filterYear" class="block w-36 px-3 py-2 mt-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">années ...</option>
                        @foreach (range(date('Y'), 2020) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Mois -->
                <div class="relative">
                    <label for="filterMonth" class="block text-sm font-medium text-gray-600">Mois</label>
                    <select id="filterMonth" class="block w-32 px-3 py-2 mt-1 text-sm text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">mois ...</option>
                        @php
                            setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');
                        @endphp
                        @foreach (range(1, 12) as $month)
                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                {{ strftime('%B', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bouton à droite -->
            <div class="relative">
                <button type="submit" form="exportForm" id="exportButton" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-400" disabled>
                    Exporter les Factures Filtrées
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <form id="exportForm" action="{{ route('listeFacture.export', ['site' => $site->id]) }}" method="POST">
                @csrf
                <table id="factures-table" class="min-w-full divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-blue-700">
                        <tr>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">N° Facture</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Client</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Site</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Date de Relevé</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Consommation (m³)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($compteurs as $compteur)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">
                                    <input type="checkbox" name="compteur_ids[]" value="{{ $compteur->id }}" class="compteur-checkbox">
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $compteur->getInvoiceData()['numero_facture'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $compteur->getInvoiceData()['client_nom'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $compteur->getInvoiceData()['site_nom'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $compteur->getInvoiceData()['date_releve'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $compteur->getInvoiceData()['consommation'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">Aucune facture trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>

        <!-- jQuery & DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script>
            $(document).ready(function () {
                const table = $('#factures-table').DataTable({
                    paging: true,
                    pagingType: 'full_numbers',
                    pageLength: 10,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    info: true,
                    language: {
                        lengthMenu: "Afficher _MENU_ factures par page",
                        zeroRecords: "Aucune facture trouvée",
                        info: "Affichage de la page _PAGE_ sur _PAGES_",
                        infoEmpty: "Aucune facture trouvée",
                        infoFiltered: "(filtré à partir de _MAX_ factures)",
                        search: "Recherche :",
                        paginate: {
                            first: "Premier",
                            last: "Dernier",
                            next: "Suivant",
                            previous: "Précédent"
                        }
                    }
                });

                // Gestion des cases à cocher
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.compteur-checkbox');
                const exportButton = document.getElementById('exportButton');

                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                    updateExportButton();
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateExportButton);
                });

                function updateExportButton() {
                    exportButton.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
                }

                // Filtres année et mois
                function applyFilters() {
                    const selectedYear = $('#filterYear').val();
                    const selectedMonth = $('#filterMonth').val();

                    table.rows().every(function () {
                        const row = this.node();
                        const dateCell = $(row).find('td').eq(4); // Colonne Date de Relevé (index 4)

                        if (dateCell.length > 0) {
                            const rowDate = new Date(dateCell.text().trim());
                            const rowYear = rowDate.getFullYear();
                            const rowMonth = rowDate.getMonth() + 1;

                            const matchesYear = selectedYear ? rowYear === parseInt(selectedYear) : true;
                            const matchesMonth = selectedMonth ? rowMonth === parseInt(selectedMonth) : true;

                            if (matchesYear && matchesMonth) {
                                $(row).show();
                            } else {
                                $(row).hide();
                            }
                        }
                    });
                }

                $('#filterYear, #filterMonth').on('change', applyFilters);
            });
        </script>

        <!-- Styles personnalisés -->
        <style>
            .dataTables_wrapper .dataTables_filter {
                float: right;
                margin-bottom: 10px;
            }
            .dataTables_wrapper .dataTables_length {
                float: left;
                margin-bottom: 10px;
            }
            .dataTables_wrapper .dataTables_paginate {
                float: right;
                margin-top: 10px;
            }
            .dataTables_paginate .paginate_button {
                padding: 0.3rem 0.6rem;
                margin-left: 2px;
                background: #2563eb;
                color: white !important;
                border: none;
                border-radius: 0.25rem;
            }
            .dataTables_paginate .paginate_button:hover {
                background: #1d4ed8;
            }
            .dataTables_paginate .current {
                background: #1d4ed8;
                font-weight: bold;
            }
            table.dataTable thead th {
                background: #2563eb;
                color: white;
                font-weight: 600;
                border-bottom: 1px solid #e5e7eb;
            }
            table.dataTable tbody tr {
                transition: background-color 0.2s;
            }
            table.dataTable tbody tr:hover {
                background-color: #f3f4f6;
            }
            .border-gray-200 {
                border-color: #e5e7eb;
            }
        </style>
    </div>
@endsection
