<?php
if (!function_exists("format_currency_helper")) {
    function format_currency_helper(float $amount, bool $withTaxes = false) {
        if ($withTaxes) {
            return (new \NumberFormatter(env('CASHIER_CURRENCY_LOCALE'), \NumberFormatter::CURRENCY))->formatCurrency(
                $amount + ($amount * env('STRIPE_TAXES') / 100), env('CASHIER_CURRENCY')
            );
        }
        return (new \NumberFormatter(env('CASHIER_CURRENCY_LOCALE'), \NumberFormatter::CURRENCY))->formatCurrency(
            $amount, env('CASHIER_CURRENCY')
        );
    }
}