@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 sm:px-6 md:px-8 pt-24 ml-16">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Relevé Consommations Clients</h1>
            <a href="{{ route('sites.compteur.create', $site) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow transition">
                <i class="fas fa-plus"></i> Ajouter un Relevé
            </a>
        </div>

        <!-- Filtres + Bouton Exporter -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-4">
                <!-- Filtre Année -->
                <div class="flex flex-col">
                    <label for="filterYear" class="text-sm font-medium text-gray-700">Année</label>
                    <select id="filterYear"
                        class="w-36 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes</option>
                        @foreach (range(2025, 2027) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Mois -->
                <div class="flex flex-col">
                    <label for="filterMonth" class="text-sm font-medium text-gray-700">Mois</label>
                    <select id="filterMonth"
                        class="w-36 px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous</option>
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

            <!-- Bouton Exporter -->
            <button id="exportButton"
    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-300">
    <i class="fas fa-file-export"></i>
    Exporter les Factures Filtrées
</button>
        </div>


        {{-- TABLEAU pour Desktop --}}
        <div class="overflow-x-auto py-4 hidden lg:block">
            <table id="compteurs-table" class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead
                    class="bg-gradient-to-r from-blue-700 to-blue-500 text-white uppercase text-xs font-semibold tracking-wider">
                    <tr>
                        <th class="px-4 py-1 text-center">N° Réf</th>
                        <th class="px-4 py-1">Nom Client</th>
                        <th class="px-4 py-1">Date Relevé</th>
                        <th class="px-4 py-1">Ancienne Date</th>
                        <th class="px-4 py-1">N° Facture</th>
                        <th class="px-4 py-1">Tarif</th>
                        <th class="px-4 py-1">Ancien Index</th>
                        <th class="px-4 py-1">Nouvel Index</th>
                        <th class="px-4 py-1">Consommation</th>
                        <th class="px-4 py-1 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($compteurs as $compteur)
                        <tr class="hover:bg-blue-50 transition" data-site-id="{{ $compteur->site_id }}"
                            data-compteur-id="{{ $compteur->id }}">
                            <td class="px-4 py-1 text-center font-medium text-gray-800">{{ $compteur->id }}</td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->client?->nom_client ?? 'Client introuvable' }}
                            </td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->date_releve }}</td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->getInvoiceData()['ancien_date'] ?? '-' }}
                            </td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->getInvoiceData()['numero_facture'] ?? '-' }}
                            </td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->client?->tarif?->nom_tarif ?? 'N/A' }}</td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->getInvoiceData()['ancien_index'] ?? '-' }}
                            </td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->getInvoiceData()['nouvel_index'] ?? '-' }}
                            </td>
                            <td class="px-4 py-1 text-gray-700">{{ $compteur->getInvoiceData()['consommation'] ?? '-' }}
                            </td>
                            <td class="px-4 py-1 text-center">
                                <div class="flex justify-center gap-4">
                                    <button class="text-yellow-500 hover:text-yellow-600 transition" title="Modifier"
                                        onclick='openEditModal({!! json_encode([
                                            'id' => $compteur->id,
                                            'nom_client' => $compteur->client?->nom_client ?? 'N/A',
                                            'date_releve' => $compteur->date_releve,
                                            'ancien_index' => $compteur->ancien_index,
                                            'nouveau_index' => $compteur->nouvel_index,
                                            'tarif' => $compteur->client?->tarif?->nom_tarif ?? 'N/A',
                                        ]) !!})'>
                                        <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <a href="{{ route('sites.compteurs.pdf.dompdf', ['site' => $site->id, 'compteur' => $compteur->id]) }}"
                                        class="text-blue-600 hover:text-blue-800 transition" title="PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <form
                                        action="{{ route('sites.compteur.destroy', ['site' => $compteur->site_id, 'compteur' => $compteur->id]) }}"
                                        method="POST" onsubmit="return confirm('Supprimer ce relevé ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- CARTES pour Mobile & Tablette --}}
        <div class="grid lg:hidden grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
            @foreach ($compteurs as $compteur)
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-md p-4 relative overflow-hidden transition hover:shadow-lg">
                    <!-- Bandeau supérieur -->
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-900 break-words leading-snug">
                            {{ $compteur->client?->nom_client ?? 'Client introuvable' }}
                        </h3>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded">
                            {{ $compteur->getInvoiceData()['numero_facture'] ?? '-' }}
                        </span>
                    </div>

                    <!-- Infos principales -->
                    <ul class="text-sm text-gray-700 space-y-1 mb-3">
                        <li><i class="fas fa-calendar-alt mr-2 text-blue-500"></i><strong>Date :</strong>
                            {{ $compteur->date_releve }}</li>
                        <li><i class="fas fa-history mr-2 text-yellow-500"></i><strong>Ancienne date :</strong>
                            {{ $compteur->getInvoiceData()['ancien_date'] ?? '-' }}</li>
                        <li><i class="fas fa-bolt mr-2 text-red-500"></i><strong>Tarif :</strong>
                            {{ $compteur->client?->tarif?->nom_tarif ?? 'N/A' }}</li>
                        <li><i class="fas fa-tachometer-alt mr-2 text-indigo-500"></i><strong>Ancien index :</strong>
                            {{ $compteur->getInvoiceData()['ancien_index'] ?? '-' }}</li>
                        <li><i class="fas fa-gauge-high mr-2 text-green-500"></i><strong>Nouvel index :</strong>
                            {{ $compteur->getInvoiceData()['nouvel_index'] ?? '-' }}</li>
                        <li><i class="fas fa-water mr-2 text-cyan-500"></i><strong>Conso :</strong>
                            {{ $compteur->getInvoiceData()['consommation'] ?? '-' }} m³</li>
                    </ul>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 border-t pt-3 mt-2">
                        <button class="text-yellow-500 hover:text-yellow-600 transition" title="Modifier"
                            onclick='openEditModal({!! json_encode([
                                'id' => $compteur->id,
                                'nom_client' => $compteur->client ? $compteur->client->nom_client : 'N/A',
                                'date_releve' => $compteur->date_releve,
                                'ancien_index' => $compteur->ancien_index,
                                'nouveau_index' => $compteur->nouvel_index,
                                'tarif' => $compteur->client && $compteur->client->tarif ? $compteur->client->tarif->nom_tarif : 'N/A',
                            ]) !!})'>
                            <i class="fas fa-pen-to-square"></i>
                        </button>

                        <a href="{{ route('sites.compteurs.pdf.dompdf', ['site' => $site->id, 'compteur' => $compteur->id]) }}"
                            class="text-blue-600 hover:text-blue-800 transition" title="PDF">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        <form
                            action="{{ route('sites.compteur.destroy', ['site' => $compteur->site_id, 'compteur' => $compteur->id]) }}"
                            method="POST" onsubmit="return confirm('Supprimer ce relevé ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 transition" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Modal d'édition -->
        <div id="editModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
            <div class="bg-white p-8 rounded shadow-lg w-1/3 relative">
                <h2 class="text-xl font-bold mb-4">Modifier le Relevé</h2>
                <form id="editForm" method="POST"
                    action="{{ route('compteurs.update', ['site' => $site->id, 'compteur' => 0]) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="site_id" value="{{ $site->id }}">
                    <input type="hidden" name="compteur_id" id="editCompteurId">

                    <!-- Informations en lecture seule -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold">Nom Client :</label>
                        <p id="displayNomClient" class="px-3 py-2 border rounded bg-gray-100"></p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold">Ancien Index :</label>
                        <p id="displayAncienIndex" class="px-3 py-2 border rounded bg-gray-100"></p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold">Tarif :</label>
                        <p id="displayTarif" class="px-3 py-2 border rounded bg-gray-100"></p>
                    </div>

                    <!-- Champs modifiables -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="date_releve" class="block text-gray-700 text-sm font-bold mb-2">Date du
                                Relevé</label>
                            <input type="date" id="editDateReleve" name="date_releve"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div>
                            <label for="nouveau_index" class="block text-gray-700 text-sm font-bold mb-2">Nouveau
                                Index</label>
                            <input type="number" id="editNouveauIndex" name="nouveau_index"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
                <button onclick="closeEditModal()" class="absolute top-0 right-0 p-2 text-white">X</button>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#compteurs-table').DataTable({
                    language: {
                        search: "🔍 Rechercher :",
                        lengthMenu: "Afficher _MENU_ entrées",
                        zeroRecords: "Aucun résultat",
                        info: "Page _PAGE_ sur _PAGES_",
                        infoEmpty: "Aucun relevé trouvé",
                        infoFiltered: "(filtré de _MAX_ relevés)",
                        paginate: {
                            next: "Suivant",
                            previous: "Précédent"
                        }
                    }
                });
            });

            function openEditModal(data) {
                document.getElementById('editCompteurId').value = data.id;
                document.getElementById('displayNomClient').textContent = data.nom_client;
                document.getElementById('displayAncienIndex').textContent = data.ancien_index;
                document.getElementById('displayTarif').textContent = data.tarif;
                document.getElementById('editDateReleve').value = data.date_releve;
                document.getElementById('editNouveauIndex').value = data.nouveau_index;

                var formAction = "{{ url('sites/' . $site->id . '/compteur') }}" + "/" + data.id;
                document.getElementById('editForm').action = formAction;

                document.getElementById('editModal').classList.remove('hidden');
            }


            // Fonction pour fermer la modal
            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
            }

            // 🔁 Filtrage personnalisé
            function applyFilters() {
                const selectedYear = $('#filterYear').val();
                const selectedMonth = $('#filterMonth').val();

                $('#compteurs-table tbody tr').each(function() {
                    const row = $(this);
                    const dateCell = row.find('td').eq(2); // Colonne date_releve
                    const dateText = dateCell.text().trim();
                    const rowDate = new Date(dateText);
                    const rowYear = rowDate.getFullYear();
                    const rowMonth = String(rowDate.getMonth() + 1).padStart(2, '0');

                    const matchesYear = selectedYear ? selectedYear == rowYear : true;
                    const matchesMonth = selectedMonth ? selectedMonth == rowMonth : true;

                    if (matchesYear && matchesMonth) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }

            // Appliquer les filtres quand ils changent
            $('#filterYear, #filterMonth').on('change', applyFilters);

            // 📤 Exportation en lot
            $('#exportButton').click(function(e) {
                e.preventDefault();
                let compteurIds = [];

                $('#compteurs-table tbody tr:visible').each(function() {
                    let siteId = $(this).data('site-id');
                    let compteurId = $(this).data('compteur-id');
                    if (siteId && compteurId) {
                        compteurIds.push({
                            site_id: siteId,
                            compteur_id: compteurId
                        });
                    }
                });

                if (compteurIds.length === 0) {
                    alert('Aucune facture filtrée à exporter.');
                    return;
                }

                $.ajax({
                    url: '{{ route('invoices.batch-export') }}',
                    method: 'POST',
                    data: {
                        compteurs: compteurIds,
                        _token: '{{ csrf_token() }}'
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        let blob = new Blob([data], {
                            type: 'application/pdf'
                        });
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'factures_filtrees_' + new Date().toISOString().slice(0, 10) +
                            '.pdf';
                        link.click();
                    },
                    error: function(xhr) {
                        alert('Erreur lors de l’exportation : ' + xhr.responseText);
                    }
                });
            });
        </script>


        <style>
            /* Espacement entre les contrôles DataTables */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 1.5rem;
            }

            .dataTables_wrapper .dataTables_info {
                margin-top: 1rem;
            }

            .dataTables_wrapper .dataTables_paginate {
                margin-top: 1.5rem;
            }

            .dataTables_wrapper .dataTables_filter {
                float: right !important;
            }

            .dataTables_wrapper .dataTables_length {
                float: left !important;
            }

            .dataTables_paginate a {
                padding: 8px 12px;
                margin: 0 4px;
                border-radius: 6px;
                background-color: #2563eb;
                color: white !important;
                text-decoration: none;
                transition: background-color 0.2s ease;
            }

            .dataTables_paginate a:hover {
                background-color: #1d4ed8;
            }

            .dataTables_paginate .current {
                background-color: #1d4ed8 !important;
                font-weight: bold;
            }
        </style>
    @endsection
