<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Payment;
use Monolog\SignalHandler;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class RazorpayController extends Controller
{
    public function payment_request(Request $request){

        $name = $request->input('name');
        $amount = $request->input('amount');

        $api = new Api(env('Razorpay_Api_Id'), env('Razorpay_Api_Secret'));
        $order  = $api->order->create(array('receipt' => '123', 'amount' => $amount * 100 , 'currency' => 'INR')); // Creates order
        $orderId = $order['id']; 

        $user_pay = new Payment();
    
        $user_pay->name = $name;
        $user_pay->amount = $amount;
        $user_pay->payment_id = $orderId;
        $user_pay->save();

        $data = array(
            'order_id' => $orderId,
            'amount' => $amount
        );

        // session(['order_id' => $orderId]);
        // session(['amount' => $amount]);
       
        return redirect()->route('home')->with('data', $data);
    }


    public function payment_response(Request $request){

        $data = $request->all();
        $user = Payment::where('payment_id', $data['razorpay_order_id'])->first();
        $user->payment_done = true;
        $user->razorpay_id = $data['razorpay_payment_id'];
        $user->payment_mode = "RazorPay";
        $api = new Api(env('Razorpay_Api_Id'), env('Razorpay_Api_Secret'));
        
        try{
        $attributes = array(
             'razorpay_signature' => $data['razorpay_signature'],
             'razorpay_payment_id' => $data['razorpay_payment_id'],
             'razorpay_order_id' => $data['razorpay_order_id']
        );
            $order = $api->utility->verifyPaymentSignature($attributes);
            $success = true;
        }catch(SignatureVerificationError $e){

            $succes = false;
        }

        if($success){
            $user->save();
            return redirect()->route('success');
        }else{

            return redirect()->route('error');
        }

    }
}