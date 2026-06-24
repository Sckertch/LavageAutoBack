<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devis extends Model
{
    protected $fillable = [
        'client_nom',
        'client_email',
        'client_telephone',
        'total_ht',
        'statut',
        'fichier_path',
    ];

    protected $casts = [
        'total_ht' => 'decimal:2',
        'statut'   => 'string',
    ];

    public function lignes(): HasMany
    {
        return $this->hasMany(DevisLigne::class);
    }
}
