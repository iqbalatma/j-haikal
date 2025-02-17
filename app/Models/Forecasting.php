<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string id
 * @property string product_id
 * @property string period
 * @property integer actual
 * @property integer actual_restock
 * @property integer prediction
 * @property integer safety_stock
 * @property integer purchasing_plan
 * @property string mad
 * @property string mse
 * @property string mape
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Forecasting extends Model
{
    use HasUuids;

    protected $table = 'forecasting';
    protected $fillable = [
        "product_id", "safety_stock", "purchasing_plan", "period", "actual", "prediction", "mad", "mse", "mape", "actual_restock", "supplier_id", "facture_id"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Produk::class, "product_id", "id");
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suplier::class, "supplier_id", "id");
    }

    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class, "facture_id", "id");
    }
}
