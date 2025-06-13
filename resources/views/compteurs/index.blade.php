@extends('layouts.app')

@section('navbar')
    @include('navbar')
@endsection

@section('content')
    <!-- Inclure DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Relevé Consommations Clients</h1>
        </div>

        <div class="flex items-center justify-between gap-4 mb-4">
            <!-- Filtres à gauche -->
            <div class="flex items-center gap-4">
                <!-- Filtre Année -->
                <div class="relative">
                    <label for="filterYear" class="block text-sm font-medium text-gray-700">Année</label>
                    <select id="filterYear"
                        class="block w-36 px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">années ...</option>
                        @foreach (range(date('Y'), 2020) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtre Mois -->
                <div class="relative">
                    <label for="filterMonth" class="block text-sm font-medium text-gray-700">Mois</label>
                    <select id="filterMonth"
                        class="block w-32 px-4 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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

            <!-- Boutons à droite -->
            <div class="relative ml-auto flex space-x-2">
                <!-- Bouton d'exportation en lot -->
                <button id="exportButton"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Exporter les Factures Filtrées
                </button>

                <!-- Bouton Ajouter un Relevé -->
                <a href="{{ route('sites.compteur.create', $site) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ajouter un Relevé
                </a>
            </div>
        </div>

        <div class="overflow-x-auto relative">
            <table id="clients-table" class="min-w-full divide-y divide-gray-200 shadow-md rounded-lg">
                <thead class="bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            N° Référence
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Nom Client
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Date du Relevé
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Ancienne Date
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            N° Facture
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Tarif
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Ancien Index
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Nouvel Index
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Consommation
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-semibold text-white uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($compteurs as $compteur)
                        <tr data-site-id="{{ $compteur->site_id }}" data-compteur-id="{{ $compteur->id }}">
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->id }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->client ? $compteur->client->nom_client : 'Client introuvable' }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">{{ $compteur->date_releve }}</td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->getInvoiceData()['ancien_date'] }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->getInvoiceData()['numero_facture'] }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->client && $compteur->client->tarif ? $compteur->client->tarif->nom_tarif : 'N/A' }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->getInvoiceData()['ancien_index'] }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->getInvoiceData()['nouvel_index'] }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                {{ $compteur->getInvoiceData()['consommation'] }}
                            </td>
                            <td class="px-4 py-1 text-sm text-gray-700 text-center">
                                <div class="flex justify-center space-x-2">
                                    <!-- Bouton d'édition -->
                                    <button class="text-yellow-500 hover:text-yellow-700"
                                        onclick='openEditModal({{ json_encode([
                                            'id' => $compteur->id,
                                            'nom_client' => $compteur->client ? $compteur->client->nom_client : 'N/A',
                                            'date_releve' => $compteur->date_releve,
                                            'ancien_index' => $compteur->ancien_index,
                                            'nouveau_index' => $compteur->nouvel_index,
                                            'tarif' => $compteur->client && $compteur->client->tarif ? $compteur->client->tarif->nom_tarif : 'N/A',
                                        ]) }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>

                                    <!-- Bouton d'exportation individuelle -->
                                    <a href="{{ route('sites.compteurs.pdf.dompdf', ['site' => $site->id, 'compteur' => $compteur->id]) }}"
                                        class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                    </a>

                                    <!-- Bouton de suppression -->
                                    <form
                                        action="{{ route('sites.compteur.destroy', ['site' => $compteur->site_id, 'compteur' => $compteur->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce relevé ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
                        <label for="date_releve" class="block text-gray-700 text-sm font-bold mb-2">Date du Relevé</label>
                        <input type="date" id="editDateReleve" name="date_releve"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label for="nouveau_index" class="block text-gray-700 text-sm font-bold mb-2">Nouveau Index</label>
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

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        // Fonction pour ouvrir la modal
        function openEditModal(compteur) {
            document.getElementById('editCompteurId').value = compteur.id;
            document.getElementById('displayNomClient').textContent = compteur.nom_client;
            document.getElementById('displayAncienIndex').textContent = compteur.ancien_index;
            document.getElementById('displayTarif').textContent = compteur.tarif;
            document.getElementById('editDateReleve').value = compteur.date_releve;
            document.getElementById('editNouveauIndex').value = compteur.nouveau_index;

            var formAction = "{{ url('sites/' . $site->id . '/compteur') }}" + "/" + compteur.id;
            document.getElementById('editForm').action = formAction;

            document.getElementById('editModal').classList.remove('hidden');
        }

        // Fonction pour fermer la modal
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // DataTables et filtres
        $(document).ready(function() {
            const table = $('#clients-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                lengthChange: true,
                info: true,
                language: {
                    lengthMenu: "Afficher _MENU_ clients par page",
                    zeroRecords: "Aucun client trouvé",
                    info: "Affichage de la page _PAGE_ sur _PAGES_",
                    infoEmpty: "Aucun client trouvé",
                    infoFiltered: "(filtré à partir de _MAX_ clients)",
                    search: "Recherche:",
                    paginate: {
                        first: "Premier",
                        last: "Dernier",
                        next: "Suivant",
                        previous: "Précédent"
                    }
                }
            });

            // Fonction pour appliquer les filtres année et mois
            function applyFilters() {
                const selectedYear = $('#filterYear').val();
                const selectedMonth = $('#filterMonth').val();

                table.rows().every(function() {
                    const row = this.node();
                    const dateCell = $(row).find('td').eq(2); // Colonne date_releve (index 2)

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

            // Événements de changement pour les filtres
            $('#filterYear, #filterMonth').on('change', applyFilters);

            // Gestion du bouton d’exportation en lot
            $('#exportButton').click(function(e) {
                e.preventDefault(); // Empêcher la redirection par défaut

                // Collecter les IDs des compteurs visibles
                let compteurIds = [];
                $('#clients-table tbody tr:visible').each(function() {
                    let siteId = $(this).data('site-id');
                    let compteurId = $(this).data('compteur-id');
                    if (siteId && compteurId) {
                        compteurIds.push({ site_id: siteId, compteur_id: compteurId });
                    }
                });

                if (compteurIds.length === 0) {
                    alert('Aucune facture filtrée à exporter.');
                    return;
                }

                // Envoyer les IDs au serveur via AJAX
                $.ajax({
                    url: '{{ route('invoices.batch-export') }}',
                    method: 'POST',
                    data: {
                        compteurs: compteurIds,
                        _token: '{{ csrf_token() }}'
                    },
                    xhrFields: {
                        responseType: 'blob' // Pour recevoir un fichier PDF
                    },
                    success: function(data) {
                        // Télécharger le PDF
                        let blob = new Blob([data], { type: 'application/pdf' });
                        let link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'factures_filtrees_' + new Date().toISOString().slice(0, 10) + '.pdf';
                        link.click();
                    },
                    error: function(xhr) {
                        alert('Erreur lors de l’exportation : ' + xhr.responseText);
                    }
                });
            });
        });
    </script>

    <!-- Styles personnalisés -->
    <style>
        select:hover {
            border-color: #4B8BF5;
        }

        table.dataTable thead th {
            background: linear-gradient(45deg, #1d4ed8, #3b82f6);
            color: #fff;
            font-weight: 600;
            border-bottom: 2px solid #2563eb;
        }

        table.dataTable tbody tr {
            transition: background-color 0.3s ease;
        }

        table.dataTable tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        div.dataTables_paginate a {
            background-color: #2563eb;
            color: #fff !important;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        div.dataTables_paginate a:hover {
            background-color: #1d4ed8;
        }

        div.dataTables_paginate .current,
        div.dataTables_paginate .paginate_button.current {
            background-color: #1d4ed8;
            font-weight: 600;
        }

        div.dataTables_wrapper .dataTables_length,
        div.dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px !important;
        }
    </style>
@endsection