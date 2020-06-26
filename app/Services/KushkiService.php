<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ConsumesExternalServices;

class KushkiService
{
    use ConsumesExternalServices;

    protected $key;

    protected $secret;

    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.kushki.base_uri');
        $this->key = config('services.kushki.key');
        $this->secret = config('services.kushki.secret');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        return "Bearer {$this->secret}";
    }

    public function handlePayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $intent = $this->createIntent($request->value, $request->currency, $request->payment_method);

        session()->put('paymentIntentId', $intent->id);

        return redirect()->route('approval');
    }

    public function handleApproval()
    {
        if (session()->has('paymentIntentId')) {
            $paymentIntentId = session()->get('paymentIntentId');

            $confirmation = $this->confirmPayment($paymentIntentId);

            if ($confirmation->status === 'requires_action') {
                $clientSecret = $confirmation->client_secret;

                return view('stripe.3d-secure')->with([
                    'clientSecret' => $clientSecret,
                ]);
            }

            if ($confirmation->status === 'succeeded') {
                $name = $confirmation->charges->data[0]->billing_details->name;
                $currency = strtoupper($confirmation->currency);
                $amount = $confirmation->amount / $this->resolveFactor($currency);
                session()->forget('cart');
                return redirect()
                ->route('shop.cart')
                ->withSuccess(['payment' => "Gracias, {$name}. Recibimos su pago de {$amount}{$currency} ."]);
            }
        }

        return redirect()
        ->route('shop.cart')
        ->withErrors('No pudimos confirmar su pago. Por favor, inténtalo de nuevo');
    }

    public function createIntent($value, $currency, $paymentMethod)
    {
        $intent = $this->makeRequest(
            'POST',
            '/card/v1/tokens',
            [],
            [
                'card' => [
                    "name"=>"TESTING",
                    "number"=>"4386261181077714",
                    "expiryMonth"=>"08",
                    "expiryYear"=>"23",
                    "cvv"=>"121"
                ],
                'totalAmount' => round($value * $this->resolveFactor($currency)),
                'currency' => strtolower($currency),
            ],
        );
        dd($intent); die();
        return $intent;
    }

    public function confirmPayment($paymentIntentId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/payment_intents/{$paymentIntentId}/confirm",
        );
    }

    public function resolveFactor($currency)
    {
        $zeroDecimalCurrencies = ['JPY'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return 1;
        }

        return 100;
    }
}