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
}
