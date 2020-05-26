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
        if($payment_method=='Rave Laravel'){

            return view('frontend.rave')->with('order_total',$order_total)
                                        ->with('first_name',$first_name)
                                        ->with('last_name',$last_name)
                                        ->with('phone_no',$phone_no)
                                        ->with('email',$email);

        }elseif($payment_method=='Rave Standard'){

            $rave_url=$this->initStandardRavePayment($email,$order_total);
            
            //redirect to page so User can pay
            return redirect()->away($rave_url);

        }
    }

    /*
    * Intialize Rave Standard Payment
    */
    public function initStandardRavePayment($email,$amount)
    {
        $curl = curl_init();

        $customer_email = $email;
        $amount = $amount;  
        $currency = "KES";
        $txref = "rave-1399338383"; // ensure you generate unique references per transaction.
        $PBFPubKey = \Config('rave.publicKey'); // get your public key from the dashboard.
        $redirect_url = "http://localhost:8000/rave/standard/callback";
        $payment_plan = ""; // this is only required for recurring payments.


        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount'=>$amount,
            'customer_email'=>$customer_email,
            'currency'=>$currency,
            'txref'=>$txref,
            'PBFPubKey'=>$PBFPubKey,
            'redirect_url'=>$redirect_url,
            'payment_plan'=>$payment_plan
        ]),
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if($err){
            // there was an error contacting the rave API
            \Log::error('Curl returned error: ' . $err);
        }

        $transaction = json_decode($response);
        
        if(!$transaction->data && !$transaction->data->link){
            // there was an error from the API
            \Log::error('API returned error: ' . $transaction->message);
        }

        return $transaction->data->link;
    }
}
