<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisLigne extends Model
{
    protected $fillable = [
        'devis_id',
        'type',
        'reference_id',
        'nom',
        'prix_unitaire',
        'quantite',
        'sous_total',
    ];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
        'sous_total'    => 'decimal:2',
        'quantite'      => 'integer',
    ];

    public function devis(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Devis::class);
    }
}
