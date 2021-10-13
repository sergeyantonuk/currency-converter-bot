<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    public $fillable = [
        'name',
        'rate',
    ];

    protected $primaryKey = 'name';

    public $incrementing = false;


    public function getRateFormattedAttribute()
    {
        $currencyRateDecimals = config('app.currency_rate_decimals');
        $rateFormatted = number_format($this->rate, $currencyRateDecimals, '.', '');

        if ($rateFormatted == 0) {
            return $this->rate;
        }
        return $rateFormatted;
    }

}
