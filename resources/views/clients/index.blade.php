@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <!-- Flex container for heading and button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Liste des Clients</h1>
            <a href="{{ route('clients.create', ['site' => $site->id]) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-4 sm:mt-0" aria-label="Ajouter un Client">
                Ajouter un Client
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Responsive table container -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">ID</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Nom</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Adresse</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Localité</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Catégorie</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Référence</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Site</th>
                        <th class="p-2 sm:p-3 text-left text-xs sm:text-sm font-medium text-gray-500 uppercase tracking-wider truncate border">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($clients as $client)
                        <tr class="hover:bg-gray-50 transition duration-300 border">
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->id }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->nom_client }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->adress_client }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->localite }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->categorie }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->ref }}</td>
                            <td class="p-2 sm:p-3 text-sm text-gray-700 truncate overflow-hidden border">{{ $client->site->nom_site }}</td>
                            <td class="p-2 sm:p-3 text-sm border">
                                <div class="flex flex-wrap">
                                    <button 
                                        class="btn btn-primary btn-view-compteurs" 
                                        data-id="{{ $client->id }}" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#compteurModal">
                                        Voir les compteurs
                                    </button>
                                    <a href="{{ route('clients.edit', ['site' => $site->id, 'client' => $client->id]) }}" class="text-yellow-500 hover:text-yellow-700 mr-2 py-1 px-2 w-full sm:w-auto border">
                                        Modifier
                                    </a>
                                    <form action="{{ route('clients.destroy', ['site' => $site->id, 'client' => $client->id]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 py-1 px-2 w-full sm:w-auto border">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- modal -->
        <div class="modal fade" id="compteurModal" tabindex="-1" aria-labelledby="compteurModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="compteurModalLabel">Liste des Compteurs</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>N° ref</th>
                                    <th>Index</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th><span id="addCompteur"  class="btn btn-primary btn-save">+</span></th>
                                </tr>
                            </thead>
                            <tbody id="compteursList">
                                <!-- Les compteurs -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--fin modal -->

    </div>
@endsection
@section('scripts')
    <script>
        const inmprimer = (idCompteur) => {
            genererFacturePDF()
        }
        var clientId = null;
        document.addEventListener('DOMContentLoaded', function () {
            const compteurModal = new bootstrap.Modal(document.getElementById('compteurModal'));

            // Charger les compteurs lorsqu'on clique sur "Voir les compteurs"
            document.querySelectorAll('.btn-view-compteurs').forEach(button => {
                button.addEventListener('click', function () {
                    clientId = this.dataset.id;

                    fetch(`/clients/${clientId}/compteurs`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            const compteurList = document.getElementById('compteursList');
                            compteurList.innerHTML = ''; // Réinitialise la liste

                            if (data.compteurs.length > 0) {
                                data.compteurs.forEach(compteur => {
                                    compteurList.innerHTML += `
                                        <tr data-id="${compteur.id}">
                                            <td class="editable" data-field="numero">${compteur.numero}</td>
                                            <td class="editable" data-field="nouvel_index">${compteur.nouvel_index}</td>
                                            <td class="editable" data-field="date_compteur">${compteur.date_compteur}</td>
                                            <td>
                                                <button class="btn btn-success btn-save" style="display:none;">Enregistrer</button>
                                            </td>
                                            <td>
                                                <i class="bi bi-trash text-danger"></i>
                                                <i class="bi bi-trash text-primary" onclick="inmprimer(${compteur.id})">download facture</i>
                                            </td>
                                        </tr>
                                    `;
                                });

                                // Attache les gestionnaires d'événements pour les cellules éditables
                                attachEditableEvents();
                            } else {
                                compteurList.innerHTML = '<tr><td colspan="4" class="text-center">Aucun compteur trouvé.</td></tr>';
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                });
            });

            function attachEditableEvents() {
                document.querySelectorAll('.editable').forEach(td => {
                    td.addEventListener('dblclick', function () {
                        const originalValue = this.textContent.trim();
                        const field = this.dataset.field;

                        // Remplace le contenu par un input
                        this.innerHTML = `<input type="text" class="form-control" value="${originalValue}">`;
                        const input = this.querySelector('input');

                        // Quand on perd le focus, on sauvegarde temporairement
                        input.addEventListener('blur', function () {
                            const newValue = input.value.trim();
                            td.textContent = newValue !== '' ? newValue : originalValue; // Restaure l'original si vide
                            td.classList.add('changed'); // Marque la cellule comme modifiée
                            td.closest('tr').querySelector('.btn-save').style.display = 'inline-block'; // Affiche le bouton Enregistrer
                        });
                        input.focus();
                    });
                });

                document.querySelectorAll('.btn-save').forEach(button => {
                    button.addEventListener('click', function () {
                        const row = button.closest('tr');
                        const compteurId = row.dataset.id;
                        const updatedData = {};

                        row.querySelectorAll('.changed').forEach(td => {
                            const field = td.dataset.field;
                            const value = td.textContent.trim();
                            updatedData[field] = value;
                        });
                        $.ajax({
                            url: `/compteurs/${compteurId}`, 
                            method: 'PUT', 
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            contentType: 'application/json',
                            data: JSON.stringify(updatedData), 
                            success: function (data) {
                                if (data.success) {
                                    $(row).find('.changed').removeClass('changed');
                                    $(button).hide();
                                    console.log('Mise à jour réussie :', data);
                                } else {
                                    alert('Erreur lors de la mise à jour.');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Erreur AJAX:', error, xhr.responseText);
                                alert(`Erreur : ${xhr.status} ${xhr.statusText}`);
                            }
                        });

                    
                    });
                });
            }
        });

        //add compteur
        document.getElementById('addCompteur').addEventListener('click', function () {
            const compteurList = document.getElementById('compteursList');
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="editable" data-field="numero">
                    <input type="text" class="form-control" placeholder="Numéro">
                </td>
                <td class="editable" data-field="nouvel_index">
                    <input type="number" class="form-control" placeholder="Nouvel Index">
                </td>
                <td class="editable" data-field="date_compteur">
                    <input type="date" class="form-control">
                </td>
                <td>
                    <button class="btn btn-success btn-save">Enregistrer</button>
                </td>
            `;

            compteurList.appendChild(newRow);

            // Ajout de l'événement au bouton Enregistrer
            newRow.querySelector('.btn-save').addEventListener('click', function () {
                const inputs = newRow.querySelectorAll('input');
                const newCompteurData = {'id_client': clientId};

                inputs.forEach(input => {
                    const field = input.closest('td').dataset.field;
                    newCompteurData[field] = input.value.trim();
                });
                console.log(JSON.stringify(newCompteurData))
                // Requête AJAX pour envoyer les données au serveur
                $.ajax({
                    url: '/compteurs', // Assurez-vous que l'URL correspond à votre route d'ajout
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(newCompteurData),
                    success: function (data) {
                        if (data.success) {
                            newRow.remove();
                            const newTr = document.createElement('tr');
                            newTr.setAttribute("data-id", `"${data.compteur.id}"`);

                            newTr.innerHTML = `
                                <td class="editable" data-field="numero">${data.compteur.numero}</td>
                                <td class="editable" data-field="nouvel_index">${data.compteur.nouvel_index}</td>
                                <td class="editable" data-field="date_compteur">${data.compteur.date_compteur}</td>
                                <td>
                                    <button class="btn btn-success btn-save" style="display:none;">Enregistrer</button>
                                </td>
                                <td>
                                    <i class="bi bi-trash text-danger"></i>
                                    <i class="bi bi-trash text-primary" onclick="inmprimer(${data.compteur.id})">download facture</i>
                                </td>`
                            document.getElementById('compteursList').appendChild(newTr);
                        } else {
                            alert('Erreur lors de l\'ajout du compteur.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur AJAX:', error, xhr.responseText);
                        alert(`Erreur : ${xhr.status} ${xhr.statusText}`);
                    }
                });
            });
        });

    </script>
@endsection
