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
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => "100.00",
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                 "cancel_url" => "http://127.0.0.1:8000/success",
                 "return_url" => "http://127.0.0.1:8000/error"
            ] 
        ]);
        // $response = $provider->createOrder([
        //     "intent" => "CAPTURE",
        //     "payment_source" => [
        //         "paypal" => [
        //             "experience_context" => [
        //                 "return_url" => route('success'),
        //                 "cancel_url" => route('error')
        //     ]]],
        //     "purchase_units" => [
        //         [
        //             "reference_id" => "d9f80740-38f0-11e8-b467-0ed5f89f718b",
        //             "amount" => [
        //                 "currency_code" => "USD",
        //                 "value" => "123"
        //             ]
        //         ]
        //     ]
        // ]);
        dd($response);
        if(isset($response['id']) && $response['id']!=null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {

                    $data = array(
                        // 'order_id' => $orderId,
                        'amount' => $request->price
                    );
            
                    // session(['order_id' => $orderId]);
                    // session(['amount' => $amount]);
                   
                    return redirect()->route('home')->with('data', $data);
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