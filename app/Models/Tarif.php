<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'site_id',
        'date',
        'nom_tarif',
        'location_compteur',
        'pu_m3_unique',
    ];

    /**
     * Relation avec le site.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
