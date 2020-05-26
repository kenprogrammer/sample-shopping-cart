<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Cart;

class StoreFrontController extends Controller
{
    /*
    * Navigate to the index page 
    * of the store front
    */
    public function index()
    {
        $products=Product::all();

        return view('frontend.index')->withProducts($products);
    }

    /*
    * Show product details
    */
    public function showProductDetails($id)
    {
        $product=Product::find($id);

        return view('frontend.product-details')->with('product',$product);
    }

    /*
    * Add item to cart
    */
    public function addTocart(Request $request)
    {
        $this->validate($request, [
            'quantity'=>'required'
        ],
        [
            'quantity.required'=>'Please enter quantity to proceed!'
        ]);
        
        $product_id=$request->input('product_id');
        $quantity=$request->input('quantity');
        $price=$request->input('price');
        $subtotal=$quantity*$price;

        $add_to_cart=Cart::create([
            "product_id"=>$product_id,
            "quantity"=>$quantity,
            "unit_price"=>$price,
            "subtotal"=>$subtotal
        ]);

        if($add_to_cart){
            return redirect('/view-cart')->with('success','Item added to cart successfully!');
        }else{
            return redirect()->withInput()->with('error','Unable to item to cart,please try again!');
        }

    }

    /*
    * View shopping cart
    */
    public function viewCart()
    {
        $cart_items=Cart::leftJoin('products', 'shopping_cart.product_id', '=', 'products.id')
                        ->select('product_id','product_name','unit_price','quantity','subtotal')->get();;

        return view('frontend.shopping-cart')->with('cart_items',$cart_items);
    }

    /*
    * Checkout
    */
    public function checkout()
    {
        $cart_items=Cart::leftJoin('products', 'shopping_cart.product_id', '=', 'products.id')
                        ->select('product_id','product_name','unit_price','quantity','subtotal')->get();;

        return view('frontend.checkout')->with('cart_items',$cart_items);
    }

    /*
    * Place Order
    */
    public function placeOrder(Request $request)
    {
        $first_name=$request->input('first_name');
        $last_name=$request->input('last_name');
        $phone_no=$request->input('phone_no');
        $email=$request->input('email');
        $order_total=Cart::sum('subtotal');
        $payment_method=$request->input('payment_method');

        //NOTE: Get country from Geo IP,currency use the store/order currency
        if($payment_method=='Rave Laravel')
        {
            return view('frontend.rave')->with('order_total',$order_total)
                                        ->with('first_name',$first_name)
                                        ->with('last_name',$last_name)
                                        ->with('phone_no',$phone_no)
                                        ->with('email',$email);
        }
    }
}
