<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    //

    protected $fillable = [
        'quotation_id',
        'product_id',
        'description',
        'duration',
        'quantity',
        'unit_price',
        'base_amount',
        'gst_rate',
        'gst_amount',
        'total_amount',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
