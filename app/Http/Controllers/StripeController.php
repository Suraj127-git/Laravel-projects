<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class StripeController extends Controller
{
    public function payment_request(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => 'pants',
                        ],
                        'unit_amount' => '100',
                    ],
                    'quantity' => '1',
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe_success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('error'),
        ]);
        //dd($response);
        if(isset($response->id) && $response->id != ''){
            session()->put('user_name', 'suraj');
            session()->put('product_name', 'pants');
            session()->put('quantity', '12');
            session()->put('price', '100');
            return redirect($response->url);
        } else {
            return redirect()->route('error');
        }
    }

    public function payment_response(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->amount = session()->get('price');
            $payment->name = session()->get('user_name');
            $payment->payment_done = true;
            $payment->payment_mode = "Stripe";
            $payment->save();

            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');
            return redirect()->route('success');

        } else {
            return redirect()->route('error');
        }
    } 
}
