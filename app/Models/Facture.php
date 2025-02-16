<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    use HasUuids;

    protected $table = "factures";
    protected $fillable = [
        "period", "supplier_id", "filename", "number", "fullpath"
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suplier::class, "supplier_id", "id");
    }
    public function forecastings(): HasMany
    {
        return $this->hasMany(Forecasting::class, 'facture_id', "id");
    }
}
