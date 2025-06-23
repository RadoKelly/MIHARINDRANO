<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_site',
        'nom_site',
        'technologie',
        'etape_avancement',
        'responsable',
        'date_debut_etape',
    ];
    
    public function clients()
    {
        return $this->hasMany(Client::class, 'id_site');
    }

    public function compteurs()
    {
        return $this->hasMany(Compteur::class, 'site_id'); // Relation avec Compteur via site_id
    }
}

