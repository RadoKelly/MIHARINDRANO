<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consommation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client',
        'id_compteur',
        'nouvel_index',
        'date_recupration',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
    public function compteur()
    {
        return $this->belongsTo(Compteur::class, 'id_compteur');
    }
}
