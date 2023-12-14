<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;

class PaypalController extends Controller
{
    public function payment_request(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $data_array = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "101.00"
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('paypal_success'),
                "cancel_url" => route('error')
            ]
        ];
        $response = $provider->createOrder($data_array);
        // dd($response);
        if(isset($response['id']) && $response['id']!=null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {
                    $data = array(
                        'order_id' => $response['id'],
                        'amount' => $request->price
                    );
                    // session(['order_id' => $orderId]);
                    // session(['amount' => $amount]);
                    // return redirect()->route('home')->with('data', $data);
                    return redirect()->away($link['href']);

                }
            }
        } else {
            return redirect()->route('error');
        }
    }
    public function payment_response(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            
            // Insert data into database
            $payment = new Payment;
            $payment->payment_id = $response['id'];
            $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payment->payment_done = true;
            $payment->payment_mode = "PayPal";
            $payment->save();

            return redirect()->route('success');
        } else {
            return redirect()->route('error');
        }
    }
}