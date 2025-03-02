<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compteur extends Model
{
    use HasFactory;
    protected $fillable = [
        'prix_par_index',
        'frais_compteur',
        'date_creation',
    ];
}
