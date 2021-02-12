<?php

use App\Models\Rate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RateSeeder extends Seeder
{

    private $url = "https://blockchain.info/ticker";

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rates = Http::get($this->url)->json();
        // create bitcoin as default currency
        Rate::query()->updateOrCreate([
            'currency' => 'BTC'],
            [
                'sell' => 1,
                'buy' => 1
            ]);

        foreach ($rates as $currency => $rate) {
            Rate::query()
                ->updateOrCreate(
                    ['currency' => $currency],
                    [
                        'buy' => $rate['buy'],
                        'sell' => $rate['sell']
                    ]
                );
        }
    }
}
