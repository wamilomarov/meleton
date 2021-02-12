<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = ['currency_id', 'buy', 'sell'];

    protected $appends = ['calculated_buy', 'calculated_sell'];

    protected $casts = [
        'rate' => 'float',
        'calculated_rate' => 'float',
    ];

    public function getCalculatedBuyAttribute()
    {
        $commissionAdded = $this->getAttribute('buy') * 1.02;
        return round($commissionAdded, 2);
    }

    public function getCalculatedSellAttribute()
    {
        $commissionAdded = $this->getAttribute('sell') * 0.98;
        return round($commissionAdded, 2);
    }
}
