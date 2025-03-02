<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_site',
        'adress_client',
        'localite',
        'categorie',
        'date_raccordement',
        'ref',
        'nom_client',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
