<?php

namespace Saeedeldeeb\PaymentGateway;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'amount',
        'methodable_id',
        'methodable_type',
        'merchant_reference',
        'status',
        'track_id'
    ];

    public function methodable()
    {
        return $this->morphTo();
    }
}
