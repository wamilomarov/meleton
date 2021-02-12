<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class ConversionLog extends Model
{
    protected $fillable = ['currency_from', 'currency_to', 'value', 'converted_value', 'rate'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format("Y-m-d H:i:s");
    }
}
