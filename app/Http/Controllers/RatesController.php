<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use App\Http\Resources\ConversionLogResource;
use App\Http\Resources\RateResource;
use App\Services\RateService;

class RatesController extends Controller
{
    protected $rateService;
    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function rates()
    {
        $rates = $this->rateService->getRates();
        return RateResource::collection($rates);
    }

    public function convert(ConvertRequest $request)
    {
        $fromRate = $this->rateService->getRateByCurrency($request->get('currency_from'));

        $toRate = $this->rateService->getRateByCurrency($request->get('currency_to'));

        $conversion = $this->rateService->convert($fromRate, $toRate, $request->get('value'));

        return ConversionLogResource::make($conversion);
    }
}
