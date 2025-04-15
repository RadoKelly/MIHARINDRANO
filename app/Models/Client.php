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
        'frais_raccordement',
        'ref',
        'nom_client',
        'tarif_id', 
        'numero_compteur',
    ];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }

        // Lier la catégorie avec le tarif automatiquement
        public function setTarifIdAttribute($value)
        {
            // Mapper les catégories aux tarifs
            $tarifs = [
                'kiosque_eau' => 1,
                'branchements_partages' => 2,
                'branchements_privés' => 3,
                'equivalents_service_public' => 4,
            ];
        
            // Vérifier si la catégorie est définie avant de l'utiliser
            if (isset($this->attributes['categorie']) && array_key_exists($this->attributes['categorie'], $tarifs)) {
                $this->attributes['tarif_id'] = $tarifs[$this->attributes['categorie']];
            }
        }
        
    

    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }

    public function compteurs()
    {
        return $this->hasMany(Compteur::class);
    }
}
