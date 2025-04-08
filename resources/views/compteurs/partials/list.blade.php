<table class="w-full border">
    <thead>
        <tr>
            <th>Client</th>
            <th>Date relevé</th>
            <th>Index</th>
            <th>Consommation</th>
            <!-- etc. -->
        </tr>
    </thead>
    <tbody>
        @forelse($compteurs as $compteur)
            <tr>
                <td>{{ $compteur->client->nom ?? '-' }}</td>
                <td>{{ $compteur->date_releve }}</td>
                <td>{{ $compteur->nouvel_index }}</td>
                <td>{{ $compteur->consommation }}</td>
                <!-- etc. -->
            </tr>
        @empty
            <tr>
                <td colspan="4">Aucun relevé trouvé.</td>
            </tr>
        @endforelse
    </tbody>
</table>
