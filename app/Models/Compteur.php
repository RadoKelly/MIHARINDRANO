<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'prix_par_index',
        'frais_compteur'
    ];

    // 🔗 Relation avec Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // 🔗 Relation avec Site
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    // 🔗 Relation avec Tarif (optionnelle si tu veux l’utiliser plus tard)
    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
