<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    //

    protected $fillable = [
        'quotation_number',
        'customer_id',
        'quotation_date',
        'valid_until',
        'subject',
        'service_arrangement',
        'gst_applicable',
        'gst_rate',
        'subtotal',
        'gst_amount',
        'grand_total',
        'status',
        'notes',
        'terms',
    ];

    protected function casts(): array
    {
        return [
            'quotation_date' => 'date:Y-m-d',
            'valid_until' => 'date:Y-m-d',
            'gst_applicable' => 'boolean',
            'gst_rate' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'gst_amount' => 'decimal:2',
            'grand_total' => 'decimal:2',
        ];
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotationItems(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }
}
