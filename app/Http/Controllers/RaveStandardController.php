<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;

class RaveStandardController extends Controller
{
    public function callback(Request $request)
    {
        if (!empty($request->get('txref'))) {
            $ref = $request->get('txref');
            $amount = Cart::sum('subtotal'); //Correct Amount from Server
            $currency = "KES"; //Correct Currency from Server
        
            $query = array(
                "SECKEY" => \Config('rave.secretKey'),
                "txref" => $ref
            );

            $data_string = json_encode($query);
                    
            $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);

            curl_close($ch);

            $resp = json_decode($response, true);

            $paymentStatus = $resp['data']['status'];
            $chargeResponsecode = $resp['data']['chargecode'];
            $chargeAmount = $resp['data']['amount'];
            $chargeCurrency = $resp['data']['currency'];

            if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {
            // transaction was successful...
                // please check other things like whether you already gave value for this ref
            // if the email matches the customer who owns the product etc
            //Give Value and return to Success page
            dd("Verification successful!");
            } else {
                //Dont Give Value and return to Failure page
                dd("Verification failed!");
            }
        }else {
            dd('No reference supplied');
        }
    }
}
