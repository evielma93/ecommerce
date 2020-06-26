<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\Classes\Cart;
use App\Currency;
use App\PaymentPlatform;
use App\Client;

class ProductController extends Controller
{


	public function index() {
        $products = Inventory::paginate(6);
        $categories = Category::get();
        $coursesPurchased = [];
        if (auth()->check()) {
            $coursesPurchased = auth()->user()->coursesPurchased();
        }
        return view("layouts.shop", compact("products", "coursesPurchased","categories"));
    }

    public function addToCart(int $id) {
        try {
            $product = Inventory::findOrFail($id);
            $cart = new Cart;
            $cart->addProduct($product);
            return back()->with('message', ['success', __("Producto añadido al carrito correctamente")]);
        } catch (\Exception $exception) {

        }
    }

    public function deleteFromCart(int $id){
        try {
            $product = Inventory::findOrFail($id);
            $cart = new Cart;
            $cart->removeProduct($product->id);
            return response()->json(['success'=>1,'message' =>'Producto eliminado del carrito correctamente']);
            //return back()->with('message', ['success', __("Producto eliminado del carrito correctamente")]);
        } catch (\Exception $exception) {

        }
    }

    public function getImageProduct($file_name){
        $file = Storage::disk('products')->get($file_name);
        return new Response($file,200);
    }

    public function shopShow()
    {
        $user = 0;
        if (\Auth::user()) {
            $user = \Auth::user()->id;
        }

        $currencies = Currency::all();
        $paymentPlatforms = PaymentPlatform::all();
        $categories = Category::get();
        $users = Client::where('user_id','=',$user)->first();
        //dump($users);
        /*if(!$users){
            echo "No hay datos registrados";
        }

        die();*/
        return view("layouts.cart",compact("categories","currencies","paymentPlatforms","users"));
    }
}
