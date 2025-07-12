<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Compteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'client_id',
        'date_releve',
        'ancien_date',
        'numero_facture',
        'tarif_id',
        'ancien_index',
        'nouvel_index',
        'consommation',
        'prix_par_index',
        'frais_compteur',
        'prix_total',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class)->withDefault(['nom_client' => 'Client inconnu']);
    }

    public function site()
    {
        return $this->belongsTo(Site::class)->withDefault(['nom_site' => 'Site inconnu']);
    }

    public function getInvoiceData()
    {
        $consommation = (float) $this->consommation ?: (float) ($this->nouvel_index - $this->ancien_index);
        $tarif = $this->client && $this->client->tarif ? $this->client->tarif : null;
        $pu_m3 = $tarif ? (float) $tarif->pu_m3_unique : 1000; // Prix unitaire par m³
        $frais_compteur = $tarif ? (float) $tarif->location_compteur : 500; // Frais compteur
        $prix_par_index = (float) ($consommation * $pu_m3);
        $hetra_fnre = $consommation * 8; // 8 Ar/m³
        $tva = $consommation > 10 ? $prix_par_index * 0.20 : 0; // TVA 20% si > 10 m³
        $reste_precedent = $this->getDernierReste();

        $prix_total = $prix_par_index + $frais_compteur + $reste_precedent;

        // Convertir le montant total en lettres (en malgache ou français)
        $formatter = new NumberFormatter('fr_FR', NumberFormatter::SPELLOUT);
        $montant_en_lettres = $formatter->format($prix_total) . ' ariary';

        return [
            'numero_facture' => $this->numero_facture ?: sprintf('%s %03d %s', $this->site->numero_site ?? '326', $this->id, Carbon::parse($this->date_releve)->format('Ym')),
            'date_releve' => $this->date_releve,
            'date_releve_formatted' => Carbon::parse($this->date_releve)->translatedFormat('F Y'),
            'ancien_date' => $this->ancien_date,
            'ancien_date_formatted' => $this->ancien_date ? Carbon::parse($this->ancien_date)->translatedFormat('F Y') : 'N/A',
            'client_nom' => $this->client->nom_client ?? 'Client inconnu',
            'client_adresse' => $this->client->adress_client ?? 'Adresse inconnue',
            'client_ref' => $this->client->ref ?? 'N/A',
            'client_numero_compteur' => $this->client->numero_compteur ?? 'N/A',
            'site_nom' => $this->site->nom_site ?? 'Site inconnu',
            'tarif_nom' => $tarif ? $tarif->nom_tarif : 'Tarif inconnu',
            'tarif_pu_m3_unique' => number_format($pu_m3, 2, '.', ''),
            'ancien_index' => number_format((float) $this->ancien_index, 2, '.', ''),
            'nouvel_index' => number_format((float) $this->nouvel_index, 2, '.', ''),
            'consommation' => number_format($consommation, 2, '.', ''),
            'prix_par_index' => number_format($prix_par_index, 2, '.', ''),
            'frais_compteur' => number_format($frais_compteur, 2, '.', ''),
            'hetra_fnre' => number_format($hetra_fnre, 2, '.', ''),
            'tva' => number_format($tva, 2, '.', ''),
            'prix_sans_tva' => number_format($prix_par_index + $hetra_fnre + $frais_compteur, 2, '.', ''),
            'prix_total' => number_format($prix_total, 2, '.', ''),
            'sarany_tsy_miova' => number_format(0, 2, '.', ''), // À ajuster selon les besoins
            'prime_fixe' => number_format(0, 2, '.', ''), // À ajuster
            'sarany_hafa' => number_format(0, 2, '.', ''), // À ajuster
            'ambiny_tsy_voaloa' => number_format($reste_precedent, 2, '.', ''), // À ajuster
            'date_fetra_fandoavana' => Carbon::parse($this->date_releve)->addDays(15)->format('Y-m-d'), // Date limite : 15 jours après relevé
            'montant_en_lettres' => ucfirst($montant_en_lettres),
        ];
    }

    public function paiements()
    {
        return $this->hasMany(Payment::class, 'compteur_id');
    }

    public function getDernierReste()
    {
        $compteurPrecedent = Compteur::where('client_id', $this->client_id)
            ->where('created_at', '<', $this->created_at)
            ->orderByDesc('created_at')
            ->first();

        if (!$compteurPrecedent) {
            return 0;
        }

        // Récupérer le dernier paiement de cette facture
        $paiement = $compteurPrecedent->paiements()->orderByDesc('created_at')->first();

        return $paiement ? $paiement->reste_a_payer : 0;
    }

    public function getFacturePrecedente()
    {
        return Compteur::where('client_id', $this->client_id)
            ->where('created_at', '<', $this->created_at)
            ->orderByDesc('created_at')
            ->first();
    }
}
