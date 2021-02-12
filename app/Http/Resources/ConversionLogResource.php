<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversionLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->currency_to == 'BTC')
        {
            $digits = 10;
        }
        else
        {
            $digits = 2;
            $this->converted_value = $this->converted_value < 0.005 ? 0.005 : $this->converted_value;
        }
        return [
            'currency_from' => $this->currency_from,
            'currency_to' => $this->currency_to,
            'value' => $this->value,
            'converted_value' => round($this->converted_value, $digits),
            'rate' => round($this->rate, $digits),
            'created_at' => $this->created_at
        ];
    }
}
