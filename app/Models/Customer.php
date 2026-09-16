<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    //

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'gstin',
        'is_active',
    ];

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}