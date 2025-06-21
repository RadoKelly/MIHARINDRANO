<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'compteur_id', // Lien avec le compteur (et donc la facture)
        'client_id', // Lien direct avec le client
        'montant_paye', // Montant payé par le client
        'date_paiement', // Date du paiement
        'reste_a_payer', // Reste à payer
        'statut', // Statut du paiement
    ];

    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class); // Nouvelle relation avec le client
    }

    public function updateResteAPayer()
{
    $factureMontant = $this->compteur->getInvoiceData()->sum('montant'); // Ajuste selon ta logique
    $this->reste_a_payer = max(0, $factureMontant - $this->montant_paye);
    $this->save();

    // Mettre à jour le statut
    if ($this->reste_a_payer == 0) {
        $this->statut = 'paye';
    } elseif ($this->reste_a_payer > 0 && $this->montant_paye > 0) {
        $this->statut = 'partiel';
    } else {
        $this->statut = 'en_attente';
    }
    $this->save();
}
}