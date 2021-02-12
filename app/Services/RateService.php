<?php


namespace App\Services;


use App\Models\ConversionLog;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class RateService
{

    public function getRates(): Collection
    {
        $rates = Rate::query()->where('currency', '!=', 'btc');
        return QueryBuilder::for($rates)
            ->allowedFilters(['currency'])
            ->allowedSorts('sell')
            ->get();
    }

    public function getRateByCurrency($currency): Model
    {
        return Rate::query()->where('currency', $currency)->first();
    }

    public function convert(Model $from, Model $to, $value): Model
    {
        $conversionRate = 1;

        if ($from->getAttribute('currency') != $to->getAttribute('currency'))
        {
            $conversionRate = $to->getAttribute('sell') / $from->getAttribute('calculated_buy');
        }

        return ConversionLog::query()
            ->create([
                'currency_from' => $from->getAttribute('currency'),
                'currency_to' => $to->getAttribute('currency'),
                'value' => $value,
                'converted_value' => $value * $conversionRate,
                'rate' => $conversionRate
            ]);
    }

}
