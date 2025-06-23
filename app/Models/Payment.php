<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'compteur_id',
        'client_id',
        'montant_paye',
        'date_paiement',
        'reste_a_payer',
        'statut',
    ];

    protected $dates = ['date_paiement', 'created_at', 'updated_at'];

    public function compteur()
    {
        return $this->belongsTo(Compteur::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function updateResteAPayer()
    {
        $factureMontant = $this->compteur ? $this->compteur->prix_total ?? 0 : 0;
        $this->reste_a_payer = max(0, $factureMontant - $this->montant_paye);
        $this->save();

        // Mettre à jour le statut selon l'enum
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