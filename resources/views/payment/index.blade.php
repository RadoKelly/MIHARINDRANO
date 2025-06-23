@extends('layouts.app')

@section('navbar')
    @include('navbar', ['site' => $site])
@endsection

@section('content')
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-700 text-center w-full">Liste des Paiements - {{ $site->nom_site }}</h1>
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

            <!-- Boutons à droite (Ajouter + Exporter) -->
            <div class="relative flex gap-2">
                <button type="button" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-400" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                    Ajouter
                </button>
                <button type="submit" form="exportForm" id="exportButton" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-400" disabled>
                    Exporter les Paiements Filtrés
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="payments-table" class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-blue-700">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">ID Paiement</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Client</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Compteur</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Montant Payé</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Date Paiement</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Reste à Payer</th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-white uppercase tracking-wider border-b border-gray-300">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($payments as $payment)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">
                                <input type="checkbox" name="payment_ids[]" value="{{ $payment->id }}" class="payment-checkbox">
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $payment->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $payment->client->nom_client ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $payment->compteur->numero_facture ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ number_format($payment->montant_paye, 2) }} MGA</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $payment->date_paiement }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ number_format($payment->reste_a_payer, 2) }} MGA</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">{{ $payment->statut }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-2 text-sm text-gray-700 text-center border-b border-gray-300">Aucun paiement trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal pour ajouter un paiement -->
        <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPaymentModalLabel">Ajouter un Paiement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('payments.store', $siteId) }}" method="POST" id="paymentForm">
                            @csrf
                            <div class="mb-3">
                                <label for="client_search" class="block text-sm font-medium text-gray-700">Nom Client</label>
                                <input type="text" id="client_search" name="client_search"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    placeholder="Recherchez un client..." autocomplete="off">
        
                                <!-- Liste des clients filtrée -->
                                <ul id="client_results"
                                    class="absolute mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden">
                                    <!-- Les résultats de recherche seront ajoutés ici -->
                                </ul>
        
                                <!-- Champ caché pour l'ID du client -->
                                <input type="hidden" id="client_id" name="client_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="compteur_numero" class="block text-sm font-medium text-gray-700">Numéro Compteur</label>
                                <input type="text" id="compteur_numero" name="compteur_numero"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="montant_total" class="block text-sm font-medium text-gray-700">Montant total à payer (MGA)</label>
                                <input type="number" id="montant_total" name="montant_total"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="montant_paye" class="block text-sm font-medium text-gray-700">Montant Payé (MGA)</label>
                                <input type="number" id="montant_paye" name="montant_paye"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="reste_a_payer" class="block text-sm font-medium text-gray-700">Reste à payer (MGA)</label>
                                <input type="number" id="reste_a_payer" name="reste_a_payer"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="date_paiement" class="block text-sm font-medium text-gray-700">Date Paiement</label>
                                <input type="date" id="date_paiement" name="date_paiement"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </div>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Ajouter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            #client_results {
                position: absolute;
                width: 100%;
                max-height: 200px;
                overflow-y: auto;
                border: 1px solid #ccc;
                background-color: white;
                z-index: 9999;
            }
        
            #client_results li {
                padding: 8px;
                cursor: pointer;
            }
        
            #client_results li:hover {
                background-color: #f1f1f1;
            }
        </style>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('client_search');
                const clientResults = document.getElementById('client_results');
                const clientIdInput = document.getElementById('client_id');
                const compteurNumeroInput = document.getElementById('compteur_numero');
                const montantTotalInput = document.getElementById('montant_total');
                const montantPayeInput = document.getElementById('montant_paye');
                const resteAPayerInput = document.getElementById('reste_a_payer');
                const form = document.querySelector('#paymentForm');
        
                searchInput.addEventListener('input', function() {
                    const query = searchInput.value.trim();
                    if (query.length < 2) {
                        clientResults.classList.add('hidden');
                        return;
                    }
        
                    fetch("{{ route('clientsPayment.search', $siteId) }}?query=" + encodeURIComponent(query))
                        .then(response => response.json())
                        .then(data => {
                            clientResults.innerHTML = '';
                            if (data.length === 0) {
                                clientResults.innerHTML = '<li class="p-2">Aucun client trouvé</li>';
                                clientResults.classList.remove('hidden');
                                return;
                            }
        
                            clientResults.classList.remove('hidden');
        
                            data.forEach(client => {
                                const li = document.createElement('li');
                                li.textContent = client.nom_client;
                                li.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');
        
                                li.addEventListener('click', function() {
                                    searchInput.value = client.nom_client;
                                    clientIdInput.value = client.id;
                                    compteurNumeroInput.value = client.compteur_numero ?? 'N/A';
                                    montantTotalInput.value = client.montant_total ?? 0;
                                    updateResteAPayer();
                                    clientResults.classList.add('hidden');
                                });
        
                                clientResults.appendChild(li);
                            });
                        })
                        .catch(error => {
                            console.error('Erreur AJAX:', error);
                        });
                });
        
                montantPayeInput.addEventListener('input', function() {
                    updateResteAPayer();
                });
        
                function updateResteAPayer() {
                    const montantTotal = parseFloat(montantTotalInput.value) || 0;
                    const montantPaye = parseFloat(montantPayeInput.value) || 0;
                    const reste = montantTotal - montantPaye;
                    resteAPayerInput.value = reste >= 0 ? reste.toFixed(2) : 0;
                }
        
                form.addEventListener('submit', function(event) {
                    if (!clientIdInput.value) {
                        alert("Veuillez sélectionner un client.");
                        event.preventDefault();
                    }
                });
            });
        </script>

        <!-- jQuery & DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <!-- Bootstrap JS pour le modal -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialisation de DataTables
        const table = $('#payments-table').DataTable({
            paging: true,
            pagingType: 'full_numbers',
            pageLength: 10,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            language: {
                lengthMenu: "Afficher _MENU_ paiements par page",
                zeroRecords: "Aucun paiement trouvé",
                info: "Affichage de la page _PAGE_ sur _PAGES_",
                infoEmpty: "Aucun paiement trouvé",
                infoFiltered: "(filtré à partir de _MAX_ paiements)",
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
        const checkboxes = document.querySelectorAll('.payment-checkbox');
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
                const dateCell = $(row).find('td').eq(5);

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

        // Initialisation de Select2
        $('#compteur_id').select2({
            placeholder: "Rechercher un compteur...",
            allowClear: true,
            ajax: {
                url: '/api/compteurs/' + {{ $siteId }} + '/search', // Corriger la syntaxe (voir ci-dessous)
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.map(compteur => ({
                            id: compteur.id,
                            text: compteur.numero_facture
                        })),
                        pagination: {
                            more: false
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        }).on('select2:select', function (e) {
            const compteurId = e.params.data.id;
            if (compteurId) {
                $.ajax({
                    url: '/api/compteurs/' + compteurId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#client_name').val(data.client_nom);
                        $('#montant_total').val(data.prix_total);
                        updateResteAPayer();
                    }
                });
            }
        });

        // Calculer le reste à payer
        $('#montant_paye').on('input', function () {
            updateResteAPayer();
        });

        function updateResteAPayer() {
            const montantTotal = parseFloat($('#montant_total').val()) || 0;
            const montantPaye = parseFloat($('#montant_paye').val()) || 0;
            const reste = montantTotal - montantPaye;
            $('#reste_a_payer').val(reste >= 0 ? reste.toFixed(2) : 0);
        }
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
            table#payments-table thead th {
                background: #2563eb !important;
                color: white !important;
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