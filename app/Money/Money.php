<?php

namespace App\Money;
use Money\Money as BaseMoney;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class Money
{
    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('MAD'));
    }

    public function formatted()
    {
        $currencies = new ISOCurrencies();

        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($this->money);
    }

    protected function currencyChanger()
    {
        return request()->currency == 'MAD' ? 1 : 10.67;
    }
}
