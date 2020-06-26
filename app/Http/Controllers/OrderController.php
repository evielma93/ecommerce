<?php

namespace App\Http\Controllers;

use App\Classes\Cart;
use App\Order;
use App\OrderLine;
use App\Product;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Exceptions\IncompletePayment;

class OrderController extends Controller
{
    public function index() {
        $orders = auth()->user()->orders()->paginate(10);
        return view("orders.index", compact("orders"));
    }

    public function show(int $id) {
        try {
            $order = Order::with("orderLines.product")->findOrFail($id);
            if ($order->user_id !== auth()->id()) {
                return back()->with("message", ["success", __("No tienes permisos para ver este pedido")]);
            }
            return view("orders.detail", compact('order'));
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function process() {
        // Si no ha registrado una tarjeta...
        if ( ! auth()->user()->hasPaymentMethod()) {
            return redirect(route("billing.credit_card_form"))->with("message", ["warning", __("Debes añadir un método de pago antes de procesar el pedido")]);
        }

        $order_id = null;

        try {
            DB::beginTransaction();

            $cart = new Cart;
            if (!$cart->hasProducts()) {
                return back()->with("message", ["danger", __("No hay productos para procesar")]);
            }

            $order = new Order;
            $order->user_id = auth()->id();
            $order->total_amount = $cart->totalAmount(false);
            $order->save();

            $order_id = $order->id;
            $orderLines = [];
            foreach ($cart->getContent() as $product) {
                $orderLines[] = [
                    "product_id" => $product->id,
                    "order_id" => $order->id,
                    "quantity" => $product->quantity,
                    "price" => $product->price,
                    "created_at" => now()
                ];
            }

            OrderLine::insert($orderLines);
            $cart->clear();
            DB::commit();

            /**
             * Cargo sin factura
             */
            //$paymentMethod = auth()->user()->defaultPaymentMethod();
            //auth()->user()->charge($order->total_amount * 100, $paymentMethod->id);

            /**
             * Cargo con factura
             */
            auth()->user()->invoiceFor(__("Compra de cursos"), $order->total_amount * 100, [], [
                'tax_percent' => env('STRIPE_TAXES'),
            ]);
            return back()->with("message", ["success", __("El pedido se ha procesado correctamente")]);
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('orders.detail', ["id" => $order_id])]
            );
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    public function invoice(string $invoice) {
        try {
            return auth()->user()->downloadInvoice($invoice, [
                'vendor' => env('APP_NAME'),
                'product' => __("Compra de cursos"),
            ]);
        } catch (\Exception $exception) {

        }
    }

    public function toCart(int $id) {
        try {
            $order = Order::with("orderLines")->findOrFail($id);
            $cart = new Cart;
            $cart->clear();
            foreach($order->orderLines as $orderLine) {
                $product = Product::find($orderLine->product_id);
                $product->quantity = $orderLine->quantity;
                $cart->addProduct($product);
            }
            $order->orderLines()->delete();
            $order->delete();
            return back()->with("message", ["success", __("El pedido ha sido volcado al carrito correctamente")]);
        } catch (\Exception $exception) {

        }
    }
}
