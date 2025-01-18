@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 md:px-8 py-8">
        <h1 class="text-2xl font-bold mb-4">Gestion des Compteurs</h1>
        <button class="bg-blue-500 text-white px-4 py-2 rounded mb-3 hover:bg-blue-700" data-bs-toggle="modal" data-bs-target="#compteurModal" onclick="resetForm()">Ajouter un Compteur</button>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Client</th>
                    <th class="py-2 px-4 border-b text-left">Numéro</th>
                    <th class="py-2 px-4 border-b text-left">Nouvel Index</th>
                    <th class="py-2 px-4 border-b text-left">Date</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="compteursTable">
                @foreach($compteurs as $compteur)
                    <tr id="compteur-{{ $compteur->id }}" class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $compteur->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $compteur->id_client }}</td>
                        <td class="py-2 px-4 border-b">{{ $compteur->numero }}</td>
                        <td class="py-2 px-4 border-b">{{ $compteur->nouvel_index }}</td>
                        <td class="py-2 px-4 border-b">{{ $compteur->date_compteur }}</td>
                        <td class="py-2 px-4 border-b">
                            <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600" onclick="editCompteur({{ $compteur }})">Modifier</button>
                            <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="deleteCompteur({{ $compteur->id }})">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="compteurModal" tabindex="-1" aria-labelledby="compteurModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="compteurForm" class="bg-white p-6 rounded-lg shadow-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="compteurModalLabel">Ajouter/Modifier un Compteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="compteurId">
                        <div class="mb-4">
                            <label for="id_client" class="block text-gray-700 text-sm font-bold mb-2">Client:</label>
                            <input type="number" id="id_client" name="id_client" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="numero" class="block text-gray-700 text-sm font-bold mb-2">Numéro:</label>
                            <input type="text" id="numero" name="numero" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="nouvel_index" class="block text-gray-700 text-sm font-bold mb-2">Nouvel Index:</label>
                            <input type="number" id="nouvel_index" name="nouvel_index" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_compteur" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                            <input type="date" id="date_compteur" name="date_compteur" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function resetForm() {
        document.getElementById('compteurForm').reset();
        document.getElementById('compteurId').value = '';
    }

    function editCompteur(compteur) {
        document.getElementById('compteurId').value = compteur.id;
        document.getElementById('id_client').value = compteur.id_client;
        document.getElementById('numero').value = compteur.numero;
        document.getElementById('nouvel_index').value = compteur.nouvel_index;
        document.getElementById('date_compteur').value = compteur.date_compteur;
        new bootstrap.Modal(document.getElementById('compteurModal')).show();
    }

    function deleteCompteur(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce compteur ?')) return;

        fetch(`/compteurs/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                document.getElementById(`compteur-${id}`).remove();
            }
        });
    }

    document.getElementById('compteurForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('compteurId').value;
        const formData = new FormData(this);
        const method = id ? 'PUT' : 'POST'; 
        formData.append('_method', method); 

        const url = id ? `/compteurs/${id}` : '/compteurs';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json()).then(data => {
            if (data.success) {
                location.reload();
            }
        }).catch(error => console.error('Erreur:', error));
    });

</script>
@endsection