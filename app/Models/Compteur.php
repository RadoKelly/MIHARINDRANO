<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_client',
        'numero',
        'nouvel_index',
        'date_compteur',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}
