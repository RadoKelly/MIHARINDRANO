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
}
