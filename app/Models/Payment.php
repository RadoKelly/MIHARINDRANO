<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_consommation',
        'montant_paye',
    ];

    public function client()
    {
        return $this->belongsTo(Consommation::class, 'id_consommation');
    }
}
