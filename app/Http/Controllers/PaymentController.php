<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resolvers\PaymentPlatformResolver;
use App\Classes\Cart;

class PaymentController extends SalesController
{
    protected $paymentPlatformResolver;

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');

        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function pay(Request $request)
    {
        $rules = [
            'value' => ['required', 'numeric', 'min:5'],
            'currency' => ['required', 'exists:currencies,iso'],
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
        ];

        //dd($request->all());

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver
        ->resolveService($request->payment_platform);

        session()->put('paymentPlatformId', $request->payment_platform);

        return $paymentPlatform->handlePayment($request);
    }

    public function approval()
    {
    	//dd('Pago aprovado'); die();
        if (session()->has('paymentPlatformId')) {
            $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval();
        }

        return redirect()
        ->route('shop.cart')
        ->withErrors('No podemos recuperar su plataforma de pago. Por favor, inténtalo de nuevo.');
    }

    public function cancelled()
    {
        return redirect()
        ->route('shop.cart')
        ->withErrors('Cancelaste el pago');
    }

    public function payTransfer(request $request)
    {
        $cart = new Cart;
        $arr = $cart->getContent();
        foreach ($arr as $key => $value) {
            echo $value->product_id;
            echo '<br>';
        }
        dump($request->all(),$arr);
        $store = $this->store($request->all());
    }
}